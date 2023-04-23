const { registerPlugin } = wp.plugins

import './core-image'
import './block-styles'
import '../blocks/partners-carousel/index'
import '../blocks/partners-marquee/index'
import '../blocks/partners-grid/index'
import '../blocks/testimonials/index'
import '../blocks/experts/index'
import '../blocks/experts-blinds/index'
import '../blocks/courses/index'
import '../blocks/team/index'
import '../blocks/personal-details/index'
import '../blocks/password-change/index'
import '../blocks/subscription-form/index'
import '../blocks/memberpress-form/index'
import './page-shadow-fields'

import HeaderComponent from './page-header-fields'
import MenuComponent from './page-secondary-nav-fields'

registerPlugin( 'wealthiher-header', {
    render() {
        return(<HeaderComponent />)
    }
} )

registerPlugin( 'wealthiher-secondary-nav', {
    render() {
        return(<MenuComponent />)
    }
} )
