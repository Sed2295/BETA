$( document ).ready(function()
{
    $('#vuelve').click(()=>{
        document.getElementById('cards').style.display='inline' 
        document.getElementById('forever').style.display='none' 
        document.getElementById('income').style.display='none' 
    } ) 
});    
    let Ing =(suma) => {
    document.getElementById('cards').style.display = 'none'   
    document.getElementById('forever').style.display = 'inline'  
    document.getElementById('income').style.display = 'inline'
    document.getElementById('titulo_card').innerHTML = "Ingresos"
    document.getElementById('datos_card').innerHTML = "Total: " + "$" + String(suma)

    }
