// selectionne l'element avec la class profile


function profilePage() {
    // mettre le display à block
    var profile = document.querySelector('.content-profile');
    profile.style.display = 'flex';
    // mettre le html en overflow-y hidden
    var html = document.querySelector('html');
    html.style.overflowY = 'hidden';
    // mettre un filtre blur a la class content
    var content = document.querySelector('.content');
    content.style.filter = 'blur(3px)';
}

// fonction qui va cacher l'element
function hideProfilePage() {
    var profile = document.querySelector('.content-profile');
    profile.style.display = 'none';
    var html = document.querySelector('html');
    html.style.overflowY = 'scroll';
    var content = document.querySelector('.content');
    content.style.filter = 'none';
}



function star1() {
    var star1 = document.querySelector('#star1');
    var star2 = document.querySelector('#star2');
    var star3 = document.querySelector('#star3');
    var star4 = document.querySelector('#star4');
    var star5 = document.querySelector('#star5');
    var note = document.querySelector('#valeurnote');
    star1.style.color = 'orange';
    star2.style.color = 'grey';
    star3.style.color = 'grey';
    star4.style.color = 'grey';
    star5.style.color = 'grey';
    note.value = 1;
}

function star2() {
    var star1 = document.querySelector('#star1');
    var star2 = document.querySelector('#star2');
    var star3 = document.querySelector('#star3');
    var star4 = document.querySelector('#star4');
    var star5 = document.querySelector('#star5');
    var note = document.querySelector('#valeurnote');
    star1.style.color = 'orange';
    star2.style.color = 'orange';
    star3.style.color = 'grey';
    star4.style.color = 'grey';
    star5.style.color = 'grey';
    note.value = 2;
}

function star3() {
    var star1 = document.querySelector('#star1');
    var star2 = document.querySelector('#star2');
    var star3 = document.querySelector('#star3');
    var star4 = document.querySelector('#star4');
    var star5 = document.querySelector('#star5');
    var note = document.querySelector('#valeurnote');
    star1.style.color = 'orange';
    star2.style.color = 'orange';
    star3.style.color = 'orange';
    star4.style.color = 'black';
    star5.style.color = 'black';
    note.value = 3;
}

function star4() {
    var star1 = document.querySelector('#star1');
    var star2 = document.querySelector('#star2');
    var star3 = document.querySelector('#star3');
    var star4 = document.querySelector('#star4');
    var star5 = document.querySelector('#star5');
    var note = document.querySelector('#valeurnote');
    star1.style.color = 'orange';
    star2.style.color = 'orange';
    star3.style.color = 'orange';
    star4.style.color = 'orange';
    star5.style.color = 'grey';
    note.value = 4;
}

function star5() {
    var star1 = document.querySelector('#star1');
    var star2 = document.querySelector('#star2');
    var star3 = document.querySelector('#star3');
    var star4 = document.querySelector('#star4');
    var star5 = document.querySelector('#star5');
    var note = document.querySelector('#valeurnote');
    star1.style.color = 'orange';
    star2.style.color = 'orange';
    star3.style.color = 'orange';
    star4.style.color = 'orange';
    star5.style.color = 'orange';
    note.value = 5;
}