document.querySelector('.burger').addEventListener('click', function() {
    document.querySelector('.burger').classList.toggle('active');
    document.querySelector('.navbar-menu').classList.toggle('open');
    document.querySelector('.overlay').classList.toggle('open');
});
document.querySelector('.overlay').addEventListener('click', function() {
    document.querySelector('.burger').classList.remove('active');
    document.querySelector('.navbar-menu').classList.remove('open');
    document.querySelector('.overlay').classList.remove('open');
});
document.querySelector('.burger') &&
    document.querySelector('.burger').addEventListener('click', function() {});
document.querySelector('.overlay') &&
    document.querySelector('.overlay').addEventListener('click', function() {});


    // var modal = document.getElementById('myModal');
    // var btn = document.getElementById("myBtn");
    // var span = document.getElementsByClassName("close")[0];

    // btn.onclick = function (){
    //     modal.style.display = "block";
    // }
    // span.onclick = function (){
    //     modal.style.display = "none";
    // }

    // window.onclick = function (event){
    //     if(event.target == modal){
    //         modal.style.display = "none";
    //     }
    // }