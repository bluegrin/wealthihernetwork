import './style/main.scss';

jQuery(document).ready(($) => {

    let backdropResize = () => {
        let wavesWidth = 1728
        let wavesHeight = 218
        let screenWidth = $(window).outerWidth()
        let backgroundHeight = $('.site-header').outerHeight() + $('.hero').outerHeight() + (wavesHeight / wavesWidth * screenWidth) + 40

        $('.backdrop').css('height', `${backgroundHeight}px`)
    }

    const siteHeader = $('body.layout-ungated .site-header, body.layout-gated .site-header')
    const siteHeaderMenuToggle = $('body.layout-ungated .site-header .menu-toggle, body.layout-gated .site-header .menu-toggle')
    const siteHeaderNavMenu = $('body.layout-ungated .site-header .nav-menu, body.layout-gated .site-header .menu')

    siteHeaderMenuToggle.on('click', () => {
        if (siteHeaderMenuToggle.hasClass('open') && siteHeaderNavMenu.hasClass('open')) {
            siteHeader.removeClass('open')
            siteHeaderMenuToggle.removeClass('open')
            siteHeaderNavMenu.removeClass('open')
        } else {
            siteHeader.addClass('open')
            siteHeaderMenuToggle.addClass('open')
            siteHeaderNavMenu.addClass('open')
        }
    })

    if ($('body.home').length) {
        backdropResize()
        $(window).on('resize', function () {
            backdropResize()
        })
    }

    if ($('.partners-carousel').length) {
        new Splide('.partners-carousel', {
            perPage: 1,
            arrows: false,
            pagination: true,
        }).mount()
    }

    if ($('.testimonials-carousel').length) {
        new Splide('.testimonials-carousel', {
            perPage: 4,
            gap: '52px',
            arrows: false,
            pagination: true,
            breakpoints: {
                1300: {
                    perPage: 3,
                    gap: '26px',
                },
                1024: {
                    perPage: 2,
                    gap: '26px',
                },
                768: {
                    perPage: 1,
                    gab: '0',
                }
            },
        }).mount()
    }

    if ($('.partners-marquee').length) {
        new Splide('.partners-marquee', {
            type: 'loop',
            autoplay: true,
            perPage: 6,
            gap: '84px',
            arrows: false,
            pagination: false,
            breakpoints: {
                1300: {
                    perPage: 6,
                    gap: '48px',
                },
                768: {
                    perPage: 4,
                    gap: '26px',
                },
            },
        }).mount()
    }

    if ($('.courses-carousel').length) {
        new Splide('.courses-carousel', {
            perPage: 4,
            gap: '32px',
            arrows: true,
            pagination: false,
            breakpoints: {
                1024: {
                    perPage: 2,
                },
                768: {
                    perPage: 1,
                },
            },
        }).mount()
    }

    if ($('.experts-carousel').length) {
        new Splide('.experts-carousel', {
            perPage: 1,
            arrows: true,
            pagination: false,
            mediaQuery: 'min',
            breakpoints: {
                1024: {
                    perPage: 3,
                },
            },
        }).mount()
    }

    if ($('#registration.splide').length) {

        let registrationForm = new Splide('#registration.splide', {
            perPage: 1,
            arrows: false,
            pagination: false,
            drag: false,
        }).mount()

        const prevButton = $('#registration-prev')
        const nextButton = $('#registration-next')
        const headings = $('#registration .heading')
        const journeyRadio = $('input[name="journey"]')

        if (0 === registrationForm.index) {
            prevButton.prop('disabled', true)
        }

        nextButton.on('click', function () {

            const i = registrationForm.index
            const slide = registrationForm.Components.Slides.getAt(i)
            const $slide = $(slide.slide)
            const messages = $slide.find('.messages')
            const busyIndicator = $('#registration .busy')

            busyIndicator.removeClass('hidden')
            messages.html('&nbsp;')
            messages.removeClass('error')

            let data = {action: 'validate_registration'}

            $.each($slide.find('input, select, textarea').serializeArray(), function (i, element) {
                data[element.name] = element.value
            })

            if (['membership', 'membership-haute'].includes(data.section)) {
                $.each($('#registration').find('input, select, textarea').serializeArray(), function (i, element) {
                    if ('section' !== element.name) {
                        data[element.name] = element.value
                    }
                })
            }

            $.ajax({
                type: 'POST',
                url: wealthiher_ajax_object.ajax_url,
                data: data,
                success: function (result) {

                    console.log(result)

                    if (result.success) {

                        if ('names' === data.section) {
                            headings.each(function (i, element) {
                                let text = $(element).text().replace('%1$s', data.user_first_name)
                                $(element).text(text)
                            })
                        }

                        if ('journey' === data.section) {

                            let $storedData = $('#stored_data')

                            let storedData = JSON.parse($storedData.val())

                            let journeys = []

                            journeyRadio.each(function (i, element) {
                                journeys.push($(element).val())
                            })

                            registrationForm.Components.Slides.forEach(function (slideComponent, i) {

                                const $slide = $(slideComponent.slide)
                                const journey = $slide.data('journey')
                                let journeyData = {}

                                if (journey in journeys) {

                                    $slide.find('input, textarea, select').each(function (i, field) {

                                        const $field = $(field)
                                        const name = $field.attr('name')

                                        if ('section' !== name) {
                                            switch ($field.attr('type')) {

                                                case 'radio':
                                                    if ($field.is(':checked')) {
                                                        journeyData[name] = $field.val()
                                                    }
                                                    break

                                                case 'checkbox':
                                                    if ($field.is(':checked')) {
                                                        journeyData[name] = 'on'
                                                    }
                                                    break

                                                default:
                                                    journeyData[name] = $field.val()
                                                    break

                                            }
                                        }

                                    })

                                    $slide.addClass('remove')

                                }

                                storedData[journey] = journeyData

                            })

                            $storedData.val(JSON.stringify(storedData))

                            registrationForm.Components.Slides.remove('.remove')

                            const template = $(`#registration-${data.journey}`)

                            let slideTemplates = (template.length) ? $(template.prop('content')).clone().find('li') : []

                            let additionalSlides = []

                            slideTemplates.each(function (i, slide) {

                                let $slide = $(slide)

                                if (data.journey in storedData) {
                                    $.each(storedData[data.journey], function (name, value) {

                                        const $inputs = $slide.find(`[name="${name}"]`)

                                        $inputs.each(function (i, input) {

                                            const $input = $(input)

                                            switch ($input.attr('type')) {

                                                case 'radio':
                                                    if ($input.val() == value) {
                                                        $input.prop('checked', true)
                                                    }
                                                    break

                                                case 'checkbox':
                                                    if ('on' == value) {
                                                        $input.prop('checked', true)
                                                    }
                                                    break

                                                default:
                                                    $input.val(value)
                                                    break

                                            }

                                        })

                                    })
                                }

                                additionalSlides.push(slide)
                            })

                            registrationForm.add(additionalSlides)

                        }

                        if (result.data.redirect) {

                            if (result.data.message) {
                                messages.html(result.data.message)
                            }

                            window.location.assign(result.data.redirect)

                        } else {
                            registrationForm.go('>')
                        }

                    } else {
                        messages.addClass('error')
                        messages.html(result.data.message)
                    }

                    busyIndicator.addClass('hidden')

                },
                error: function () {
                    messages.addClass('error')
                    messages.html('There was a problem processing your form. Please try again later or contact support.')
                    busyIndicator.addClass('hidden')
                },
            })

        })

        prevButton.on('click', function () {
            registrationForm.go('<')
        })

        registrationForm.on('moved', function () {
            prevButton.prop('disabled', false)
            nextButton.prop('disabled', false)

            if (0 === registrationForm.index) {
                prevButton.prop('disabled', true)
            }

            let last = registrationForm.Components.Slides.get().length - 1

            const slide = registrationForm.Components.Slides.getAt(registrationForm.index)
            const $slide = $(slide.slide)

            if (last === registrationForm.index && !$slide.hasClass('registration-journey')) {
            }
        })

        journeyRadio.on('change', function () {

            const option = $(this).val()
            const selector = `#registration-${option}`

            if ($(selector).length) {
                nextButton.prop('disabled', false)
            }

        })

        // let littleDate = new Date()
        //
        // let warwickNeedsHelp = {
        //     user_first_name: 'Warwick',
        //     user_last_name: 'Anderson',
        //     user_email: 'warwick+' + littleDate.getFullYear() + littleDate.getMonth() + littleDate.getDate() + littleDate.getHours() + littleDate.getMinutes() + littleDate.getSeconds() + '@thinkcraft.co.za',
        //     mepr_user_password: 'One2#',
        //     mepr_user_password_confirm: 'One2#',
        //     mepr_job_level: 'c-suite',
        //     mepr_company: 'Think Craft',
        // }
        //
        // $.each(warwickNeedsHelp, function (field, dummy) {
        //     $(`#${field}`).val(dummy)
        // })
        //
        // $('#mepr_interests_networking').prop('checked', true)

    }

    let academyReelsOptions = {
        perPage: 1,
        gap: '32px',
        arrows: true,
        pagination: false,
        mediaQuery: 'min',
        breakpoints: {
            768: {
                perPage: 2,
            },
            1024: {
                perPage: 3,
            },
        },
    }

    let gatedCarouselSelectors = [
        'body.layout-gated .entry-content-mpcs-course #continue .splide',
        'body.layout-gated .entry-content-mpcs-course #curated .splide',
        'body.layout-gated .entry-content-mpcs-course #completed .splide',
        'body.layout-gated .entry-content-mpcs-course #upcoming .splide',
        'body.layout-gated .entry-content-tribe_events #upcoming .splide',
        'body.layout-gated .entry-content-tribe_events #nearest .splide',
    ]

    $.each($('body.layout-gated .entry-content-mpcs-course .lessons'), function (i, element) {
        if ($(element).find('.splide').length) {
            gatedCarouselSelectors.push(`body.layout-gated .entry-content-mpcs-course #${$(element).attr('id')} .splide`)
        }
    })

    $.each(gatedCarouselSelectors, function (i, selector) {
        if ($(selector).length) {
            new Splide(selector, academyReelsOptions).mount()
        }
    })

    if ($('.experts-blinds').length) {

        let blinds = $('.experts-blinds .expert')

        blinds.on('click', function () {
            if ($(this).hasClass('closed')) {

                blinds.each(function (i, blind) {
                    $(blind).addClass('closed')
                })

                $(this).removeClass('closed')

            }
        })

    }

    $('.button-check input[type="checkbox"]').on('change', function () {

        if ($(this).is(':checked')) {
            $(this).closest(('.button-check')).removeClass('button-unchecked').addClass('button-checked')
        } else {
            $(this).closest(('.button-check')).removeClass('button-checked').addClass('button-unchecked')
        }

    })

    $('.lessons-toggle, .entry-content-mpcs-course .section-header .heading').on('click', function () {
        let section = $(this).closest('li.section')

        if (section.hasClass('open')) {
            section.removeClass('open').addClass('closed')
        } else {
            section.removeClass('closed').addClass('open')
        }
    })

    $('#user_login').attr('placeholder', 'your@emailgoes.here')
    $('#user_pass').attr('placeholder', 'password')

    $('.mepr-cancel-sub-text').html('<h3>Are you sure?</h3><p>Are you sure you want to cancel your WealthiHer digital pass? This means you no longer have access to your courses and your progress will be lost.</p>')
    $('.mepr-cancel-sub-buttons .mepr-confirm-no').html('No, I want to stay')
    $('.mepr-cancel-sub-buttons .mepr-confirm-yes').html('Cancel my membership')

    $('#basic-local-avatar, #basic-user-avatar-erase').on('change', function () {
        $(this).closest('#basic-user-avatar-form')[0].submit()
    })

    $('#quiz-save').on('click', function () {

        let formData = new FormData()

        formData.append('action', 'mpcs_submit_quiz')
        formData.append('post_id', MpcsQuizL10n.post_id)
        formData.append('attempt_id', MpcsQuizL10n.attempt_id)
        formData.append('_ajax_nonce', MpcsQuizL10n.submit_quiz_nonce)

        $('.mpcs-quiz-question').find('input, textarea, select').each(function (i, element) {
            formData.append(element.name, element.value)
        })

        $.ajax({
            method: 'POST',
            url: MpcsQuizL10n.ajax_url,
            data: formData,
            processData: false,
            contentType: false,
        }).done(function (result) {
        })

    })
})
