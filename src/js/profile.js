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
