$( document ).ready(() => {
    $('#rep').click( () => {
        $('#collap_rep').collapse('toggle')
        $('#collapseExample').collapse('hide')
        $('#collapseExample2').collapse('hide')
        $('#collapseExample3').collapse('hide')
        $('#collapseExample4').collapse('hide')
    })
    $('#cp').click( () => {
        $('#collap_rep').collapse('hide')
        $('#collapseExample').collapse('toggle')
        $('#collapseExample2').collapse('hide')
        $('#collapseExample3').collapse('hide')
        $('#collapseExample4').collapse('hide')
    })
    
    $('#ce').click( () => {
        $('#collap_rep').collapse('hide')
        $('#collapseExample1').collapse('hide')
        $('#collapseExample2').collapse('toggle')
        $('#collapseExample3').collapse('hide')
        $('#collapseExample4').collapse('hide')
    })
    $('#pag').click( () => {
        $('#collap_rep').collapse('hide')
        $('#collapseExample2').collapse('hide')
        $('#collapseExample3').collapse('toggle')
        $('#collapseExample4').collapse('hide')
    })
    $('#cat').click( () => {
        $('#collap_rep').collapse('hide')
        $('#collapseExample1').collapse('hide')
        $('#collapseExample2').collapse('hide')
        $('#collapseExample3').collapse('hide')
        $('#collapseExample4').collapse('toggle')
    })
});