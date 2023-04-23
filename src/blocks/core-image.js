console.log('got here')

let modBlockEdit = ( ...args) => {
    return (
        <div className='component'></div>
    )
}

wp.hooks.addFilter(
    'blocks.blockEdit',
    'wealthiher/modBlockEdit',
    modBlockEdit
)