function hideLoader() {
    $(".loader-wrapper").fadeOut("slow");
}

const favIcon = document.querySelector("#fav-icon");
const isDark = window.matchMedia("('prefers-colors-scheme: dark')");

function changeFavIco() {
    isDark.matches ? favIcon.href = "/main-assets/imgs/light-logo.png" : favIcon.href = "/main-assets/imgs/dark-logo.png";
}

changeFavIco();

$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});