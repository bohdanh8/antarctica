document.addEventListener('click', function (e) {
    let headerSearchForm = document.querySelector('.search-form');

    if (headerSearchForm && headerSearchForm.classList.contains('is-active')) {
        if (e.target.closest('.js-search-box') || e.target.classList.contains('js-search-box')) {
            return;
        }

        headerSearchForm.classList.remove('is-active');
        e.stopPropagation();
    }
});

document.querySelectorAll('.js-search-toggle').forEach(function (toggle) {
    toggle.addEventListener('click', function (e) {
        let headerSearch = toggle.closest('.js-search-box');
        let searchInputWrap = headerSearch.querySelector('.search-form');

        if (searchInputWrap && !searchInputWrap.classList.contains('is-active')) {
            searchInputWrap.classList.add('is-active');
            let input = searchInputWrap.querySelector('[name="s"]');
            if (input) {
                input.focus();
            }
            e.preventDefault();
            e.stopPropagation();
        } else if (searchInputWrap && searchInputWrap.classList.contains('is-active')) {
            if (searchInputWrap.querySelector('input').value === '') {
                searchInputWrap.classList.remove('is-active');
            } else {
                searchInputWrap.submit();
            }
            e.preventDefault();
            e.stopPropagation();
        }
    });
});
