function searchByValue() {
    const searchValue = $('#search_value').val();
    if (searchValue) {
        setFilter({id: searchValue, title_en: searchValue}, 'search_value')
    }

    function setFilter(data, key) {
        if (!data.id) {
            removeFilter(key)
            return;
        }

        const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : {};
        filterData[key] = data;

        localStorage.setItem('filter', JSON.stringify(filterData));

        loadFilters()
        loadData()

        window.history.pushState({}, document.title, getQueryParams());
    }
}

function removeFilter(key) {
    const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : null;
    if (filterData) {
        delete filterData[key];
        localStorage.setItem('filter', JSON.stringify(filterData));
        loadFilters()
    }

    window.history.pushState({}, document.title, getQueryParams());

    loadData()

    if (key === 'search_value') {
        $('#search_value').val('')
    } else if (key === 'category') {
        $("#all_cat").prop("checked", true);
    } else if (key === 'industry_type_id') {
        $("#any_industry").prop("checked", true);
    } else if (key === 'organization_type_id') {
        $("#any_organization").prop("checked", true);
    } else if (key === 'post_within') {
        $("#any_post_within").prop("checked", true);
    } else if (key === 'deadline') {
        $("#any_deadline").prop("checked", true);
    } else if (key === 'exp_range') {
        $("#exp_range").val('{"id": "", "title_en": ""}');
    } else if (key === 'age_range') {
        $("#age_range").val('{"id": "", "title_en": ""}');
    } else if (key === 'job_nature') {
        $("#job_nature").val('{"id": "", "title": ""}');
    } else if (key === 'job_level') {
        $("#job_level").val('{"id": "", "title": ""}');
    } else if (key === 'work_from_home') {
        $('#work_from_home').prop('checked', false);
    } else if (key === 'g_male') {
        $('#g_male').prop('checked', false);
    } else if (key === 'g_female') {
        $('#g_female').prop('checked', false);
    } else if (key === 'g_other') {
        $('#g_other').prop('checked', false);
    }
}

function loadFilters() {
    const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : null;
    if (filterData && !jQuery.isEmptyObject(filterData)) {
        let filterHtml = '';
        $.each(filterData, function (key, item) {
            if (key === 'per_page') {
                return;
            }

            if (key === 'job_nature' || key === 'job_level') {
                filterHtml += `<div class="filter-reg">
                                        <span class="filter-reg-item">
                                            ${item.title}
                                            <a href="javascript:" class="ml-1" onclick="removeFilter('${key}')"><i class="icofont-close-circled"></i></a>
                                        </span>
                                    </div>`
            } else {
                filterHtml += `<div class="filter-reg">
                                        <span class="filter-reg-item">
                                            ${formattedTitle(item)}

                                            <a href="javascript:" class="ml-1" onclick="removeFilter('${key}')"><i class="icofont-close-circled"></i></a>
                                        </span>
                                    </div>`
            }

            setFiltersDefaultValue(key, item);
        });

        $('#filter_section').html(filterHtml);
    } else {
        $('#filter_section').empty();
    }
}

function formattedTitle(item) {
    const currentLang = Cookies.get('lang');

    if (currentLang === 'bn') {
        return item.title_bn;
    }
    return item.title_en;
}


function loadData() {
    $.ajax({
        url: formattedUrl("job-lists" + getQueryParams()),

        beforeSend: function () {
            $("#loader").show();
        },
        complete: function () {
            $("#loader").hide();
        },
    }).done(function (data) {
        $("#data_content").html(data.html)
        $("#total_records").html(data.totalRecords)

    }).fail(function () {
        alert('No response from server');
    });
}

function formattedUrl(url) {
    const location = document.createElement("a");
    location.href = url;

    const currentLang = Cookies.get('lang') === 'en' ? '' : '/' + Cookies.get('lang');

    return currentLang + location.pathname + location.search;
}

function getQueryParams() {
    const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : null;
    let queryParams = '';
    if (filterData) {
        queryParams = '?'
        $.each(filterData, function (key, item) {
            const obj = {}
            obj[key] = item.id
            queryParams += '&' + $.param(obj)
        });
    }
    return queryParams;
}

function setFiltersDefaultValue(key, item) {
    if (key === 'search_value') {
        $('#search_value').val(item.id)
    } else if (key === 'category') {
        $(`#cat_${item.id}`).prop("checked", true)
    } else if (key === 'industry_type_id') {
        $(`#industry_${item.id}`).prop("checked", true);
    } else if (key === 'organization_type_id') {
        $(`#organization_${item.id}`).prop("checked", true);
    } else if (key === 'post_within') {
        $(`#post_within${item.id}`).prop("checked", true);
    } else if (key === 'deadline') {
        $(`#deadline${item.id}`).prop("checked", true);
    } else if (key === 'exp_range') {
        $("#exp_range").val(JSON.stringify(item));
    } else if (key === 'age_range') {
        $("#age_range").val(JSON.stringify(item));
    } else if (key === 'job_nature') {
        $("#job_nature").val(JSON.stringify(item));
    } else if (key === 'job_level') {
        $("#job_level").val(JSON.stringify(item));
    } else if (key === 'work_from_home') {
        $('#work_from_home').prop('checked', item.id);
    } else if (key === 'g_female') {
        $('#g_female').prop('checked', item.id);
    } else if (key === 'g_male') {
        $('#g_male').prop('checked', item.id);
    } else if (key === 'g_other') {
        $('#g_other').prop('checked', item.id);
    }
}
