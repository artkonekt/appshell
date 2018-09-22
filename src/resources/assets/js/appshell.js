function ready(fn) {
    if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading"){
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

ready(function () {
    document.querySelectorAll('.nav-dropdown-toggle').forEach(function (item) {
        item.addEventListener('click', function (event) {
            event.target.parentNode.classList.toggle('open')
        });
    });
});

