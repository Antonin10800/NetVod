// selectionne l'element avec la class profile


function profilePage() {
    // mettre le display à block
    var profile = document.querySelector('.profile');
    profile.style.display = 'flex';
    // mettre le html en overflow-y hidden
    var html = document.querySelector('html');
    html.style.overflowY = 'hidden';
}

// fonction qui va cacher l'element
function hideProfilePage() {
    var profile = document.querySelector('.profile');
    profile.style.display = 'none';
    var html = document.querySelector('html');
    html.style.overflowY = 'scroll';
}
