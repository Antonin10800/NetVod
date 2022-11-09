// selectionne l'element avec la class profile


function profilePage() {
    // mettre le display à block
    var profile = document.querySelector('.profile');
    profile.style.display = 'flex';
}

// fonction qui va cacher l'element
function hideProfilePage() {
    var profile = document.querySelector('.profile');
    profile.style.display = 'none';
}
