$(document).ready(function() {
    if ($('.filter-sidebar').length > 0) {
        
        $('.filter-sidebar__taxonomy-title').click(function() {
            $(this).toggleClass('active');
            $('.taxonomy-' + $(this).attr('data-target')).slideToggle();
        });

        // Get params from URL and apply to filters
        if (window.location.search != '') {
            autoPopulateFiltersFromURL();
        }

        // Fetch initial posts
        doFilter();

        $('.btn-do-filter').on('click', function() {
            $('#paged').val(1);
            doFilter();
        });

        // Posts Search field
        $('.search-field').on('keyup', function(e) {
            if (e.keyCode === 13) {
                doSearch();
            }
        });

        $('.search-button').on('click', function() {
            $('#paged').val(1);
            doFilter();
        })

        // Remove filter
        $(document).on('click', '.btn-remove-filter', function(){
            var tax = $(this).attr('data-tax');
            var term = $(this).attr('data-term');
            $(this).remove();
            $('.checkbox-terms[value='+term+']').parent('.input-checked').removeClass('input-checked')
            $('.checkbox-terms[value='+term+']').attr('checked', false);
            $('.checkbox-terms[value='+term+']').prop('checked', false);
            doFilter();
        });

        // Pagination
        /*$(document).on('click', '.results-container__pagination a.page-numbers', function(){
            if (!jQuery(this).hasClass('disabled')) {
                if (jQuery(this).text() > 0) {
                    jQuery('#paged').val(jQuery(this).text());
                } else if (jQuery(this).hasClass('prev')) {
                    jQuery('#paged').val((jQuery('#paged').val()*1)-1);
                } else if (jQuery(this).hasClass('next')) {
                    jQuery('#paged').val((jQuery('#paged').val()*1)+1);
                }
            }
            
            doFilter();
        });*/
        $('.button-load-more').click(function () {
            var paged = parseInt($('#paged').val()) + 1;
            $('#paged').val(paged);
 
            // Load more Blog Resources
            doFilter();
        });

        // Clear Filters
        $(document).on('click','.button__clear-all' ,function () {
            // Remove params from URL
            removeURLParameters();

            // Remove current content
            // $('.archive-resources__content').empty();
            $('.tags-filtered').empty();

            $('.checkbox-terms').prop('checked', false);
            clearFilterTerms();
            $('.field-search-ajax').val('');

            $('#paged').val(1);
            // $(this).css('display', 'none');

            // Empty date filters
            $('input[name=date-range]').prop('checked', false);
            $('.date-inputs').css('display', 'none');
            $('#filter-date-from').val('');
            $('#filter-date-from').attr('type', 'text');

            $('#filter-date-to').val('');
            $('#filter-date-to').attr('type', 'text');

            // Reset resources results
            doFilter();
        });

        // Styles for the checkbox
        $('.terms li').on('click',function(){
            if($(this).hasClass('input-checked')){
                $(this).removeClass('input-checked')
                $(this).find('.checkbox-terms').attr('checked', false).change();
            }else{
                $(this).addClass('input-checked')
                $(this).find('.checkbox-terms').attr('checked', true).change();
            }

            // Count terms selected for that taxonomy
            var count = 0;
            var tax = $('input', this).attr('data-tax');
            $('ul[data-tax="' + tax + '"] li input').each(function() {
                if ($(this).is(':checked')) {
                    count++;
                }
            });
            // Modify the count for that taxonomy
            if (count > 0)
                $('h4[data-target="' + tax + '"] .count').html( '(' + count + ')' );
            else 
                $('h4[data-target="' + tax + '"] .count').html( '' );
        });
        
        // Reveal filters on Mobile
        $('.mobile-filter-group > h4').on('click',function(){
            $('.filter-taxonomy-container').slideToggle('slow');
        })

        // Check for mobile to reveal filters 
        var windowsize = $(window).width();
        $(window).resize(function() {
            windowsize = $(window).width();
            if (windowsize >= 768) {
                $('.filter-taxonomy-container').slideDown();
            }
        });

        // Search button functionality
        /*$('.search-ajax-button').on('click', function() {
            if ($('.field-search-ajax').val() != '') {
                // Do a smooth scroll to view results in case the results are not on the viewport
                $('html, body').animate({
                    scrollTop: $('.search-ajax-button').offset().top
                  }, 800);
    
                doFilter(); // Filter results based on search criteria
            }
        });*/

        // Hiding blur when scroll is at the bottom of the listing
        $('ul.terms').scroll(function() {
            var div_height = 200;

            if (($(this).scrollTop()) >= ($(this)[0].scrollHeight - div_height)) {
                $(this).parent().addClass('remove-blur');
            } else {
                $(this).parent().removeClass('remove-blur');
            }
        });

        // Filter terms while typing on the search input
        $('.search-terms').keyup(function(e) {
            var search_term = $(this).val();

            $('input[data-tax=' + $(this).attr('data-tax-target')).each(function() {
                var input_value = $(this).attr('data-name');

                if (search_term == '' || input_value.toLowerCase().match(search_term)) {
                    $(this).parent().css('display', '');
                } else {
                    $(this).parent().css('display', 'none');
                }
            });
        });

        $('.filters-sort').change(function() {
            $('#paged').val('1');
            doFilter();
        });

        // Date Range
        $('.radio-terms').change(function() {
            if ($(this).val() == 'custom') {
                $('.date-inputs').css('display', 'flex');
            } else {
                $('.date-inputs').css('display', 'none');
                $('#filter-date-from').val('');
                $('#filter-date-from').attr('type', 'text');

                $('#filter-date-to').val('');
                $('#filter-date-to').attr('type', 'text');
            }
        }); 

        $('#filter-date-from').focus(function() {
            $(this).attr('type', 'date');
        });
        $('#filter-date-from').blur(function() {
            if ($(this).val() == '') 
                $(this).attr('type', 'text');
        });

        $('#filter-date-to').focus(function() {
            $(this).attr('type', 'date');
        });
        $('#filter-date-to').blur(function() {
            if ($(this).val() == '') 
                $(this).attr('type', 'text');
        });
    }
});

function doFilter() {

    // Scroll to top to avoid staying at the bottom
    /*$('html, body').animate({
        scrollTop: $('.archive-resources__listing').offset().top
    }, 800);*/

    // Hide pagination 
    //$('.results-container__pagination').html('');
    $('.button-load-more').css('display', 'none');

    // Show loading
    $('.spinner').addClass('loading');
    
    // If we are pulling first page, remove all previous posts
    if ($('#paged').val() == 1) 
        $('.results-container__posts').empty();

    // Check if we are hiding filters and filtering for a custom tax
    $('.tags-filtered').empty(); // Clear old filter terms
    var terms = getFilterTerms(); // Get Terms

    console.log(terms);
    console.log(Object.keys(terms).length);
    // Show clear all if there are filters
    if (Object.keys(terms).length > 0) {
        $('.button__clear-all').css('display', 'flex');
    } else {
        $('.button__clear-all').css('display', 'none');
    }

    var date_range = getDateRange();
    var orderby = getOrderBy();

    // Build URL Parameters
    buildURLParameters(terms, $('input[name=date-range]:checked').val(), date_range, orderby);

    // AJAX call
    $.ajax({
        url: ajax_var.url,
        method: 'POST',
        data: {
            action: $('#action').val(),
            post_type: $('#post_type').val(),
            terms: terms,
            orderby: orderby,
            search: $('.field-search-ajax').val(),
            paged: $('#paged').val(),
        }, success: function (response) {

            if (response && response.success) {
                // Add new content
                if (response.data.count > 0) {

                    // Scroll To last post row if page is not the first one
                    if ($('#paged').val() != 1) {
                        $('html, body').animate({scrollTop: $('.results-container__loader').offset().top}, 'slow');
                    }

                    if (response.data.count < response.data.posts_per_page)
                        var results_found = response.data.count + ' out of ' + response.data.count + ' results showing';
                    else 
                        var results_found = (response.data.posts_per_page * $('#paged').val()) + ' out of ' + response.data.count + ' results showing';
                    

                    $('.results-found-qty').html(results_found);
                    $('.results-container__posts').append(response.data.html);
                } else {
                    $('.results-container__posts').html('No results found');
                    $('.results-found-qty').html('0 results showing');
                }

                

                // Hide loading
                $('.spinner').removeClass('loading');

                // Check if I need to show again the pagination
                //if (response.data.pagination) {
                if (response.data.see_more) {
					$('.button-load-more').css('display', 'inline-block');
                    //$('.results-container__pagination').html(response.data.pagination);
                    //modifyPaginationLinks();
                }
            }
        }, error: function (error) {
            console.log(error);

            // Hide loading
            $('.spinner').removeClass('loading');
        }
    });

    $('.filter-taxonomy-container .filter-sidebar__taxonomy').each(function(){
        var taxCount = 0;
        $(this).find('.input-checked').each(function(){
                taxCount = taxCount + 1;
        })
        if (taxCount > 0)
            $(this).find('.filter-sidebar__taxonomy-title .count').text('('+ taxCount + ')');
        else {
            $(this).find('.filter-sidebar__taxonomy-title .count').text('');
        }
    })

    var globalCount = $('.results-container .tags-filtered .tag-button').length;
    $('.mobile-filter-group .global-count').text('(' + globalCount + ')')

}

function getFilterTerms() {
    var terms = {};
    $('ul.terms').each(function() {
        $('.checkbox-terms', this).each(function() {
            if ($(this).is(':checked')) {
                if ($(this).attr('data-tax') in terms == false) 
                    terms[$(this).attr('data-tax')] = [];
                
                terms[$(this).attr('data-tax')][terms[$(this).attr('data-tax')].length] = $(this).val();

                $('.tags-filtered').append('<a href="javascript: void(0)" data-tax="' + $(this).attr('data-tax') + '" data-term="' + $(this).val() + '" title="' + $(this).attr('data-name') + '" class="btn-remove-filter tag-button tag-button-' + $(this).attr('data-tax') + '-' + $(this).val() + '"><span class="button-text">' + $(this).attr('data-name') + '</span><img src="/wp-content/themes/riva-wp/images/icons/icon-close.svg"></a>');
            }
        });
    });

    return terms;
}

function clearFilterTerms() {
    $('.checkbox-terms').each(function() {
        //$(this).attr('checked', false);
        $(this).prop('checked', false);
    });
    $('.input-checked').removeClass('input-checked')
}

function doSearch() {
    $('#paged').val('1');
    doFilter();
}

function removeFilter(tax, term) {
    $('.tag-button-' + tax + '-' + term).remove();
    $('.checkbox-terms').each(function() {
        if ($(this).attr('data-tax') == tax && $(this).val() == term)
            $(this).prop('checked', false);
    });
    removeURLParameters();
    doFilter();
}

function getDateRange() {
    var dates_range = ["", ""];
    if ($('#filter-date-from').val() != '' && $('#filter-date-from').val() != '') {
        dates_range[0] = $('#filter-date-from').val();
        dates_range[1] = $('#filter-date-to').val();
    }
    return dates_range;
}

function getOrderBy() {
    return $('.filters-sort').val();
}

function modifyPaginationLinks() {
    // Modify href of each pagination link to perform a JS call
    jQuery('.results-container__pagination a.page-numbers').each(function() {
        if (!jQuery(this).hasClass('disabled')) {
                jQuery(this).attr('href', 'javascript: void(0);')
        }
    });
}

// Build the URL parameters as the users filters
function buildURLParameters(terms, date_filter, date_range, order_by) {
    // Add filters used to URL as params. This is used to save filters on URL to allow sharing
    var current_url = window.location.protocol + "//" + window.location.host + window.location.pathname;
    var url_params = '';

    // Loop terms
    $.each( terms, function( key, value ) {
        url_params += (url_params == '') ? '?' : '&';
        url_params += key + '_filter=' + value;
    });

    // Date range
    if (date_filter) {
        url_params += (url_params == '') ? '?' : '&';

        url_params += 'date_filter=' + date_filter;
        if (date_filter == 'custom') {
            url_params += '&date_from=' + date_range[0] + '&date_to=' + date_range[1];
        } 
    }

    // Order By
    if (order_by && url_params != '') { // If we don't have other url parameters, don't save the order by on the URL
        url_params += (url_params == '') ? '?' : '&';
        url_params += 'order_by=' + order_by;
    }

    current_url += url_params;
    
	window.history.pushState({ path: current_url }, '', current_url);
}

function removeURLParameters() {
    var current_url = window.location.protocol + "//" + window.location.host + window.location.pathname;
    window.history.pushState({ path: current_url }, '', current_url);
}

// Used on load page to get all URL parameters
function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

function autoPopulateFiltersFromURL() {
    
    $('ul.terms').each(function() {
        var params_str = getUrlParameter($(this).attr('data-tax') + '_filter');
        if (params_str) {
            var params_arr = params_str.split(",");
            for (i=0; i < params_arr.length; i++) {
                $('input[data-tax=' + $(this).attr('data-tax') + ']').each(function() {
                    if ($(this).val() == params_arr[i]) {
                        $(this).prop('checked', true);
                        $(this).parent().addClass('input-checked');
                    }
                });
            }
        }
    });

    var date_filter = getUrlParameter('date_filter');
    if (date_filter) {
        $('.radio-terms[value=' + date_filter + ']').prop('checked', true);

        if (date_filter == 'custom') {
            $('.date-inputs').css('display', 'flex');
            
            $('#filter-date-from').val(getUrlParameter('date_from'));
            $('#filter-date-from').attr('type', 'date');

            $('#filter-date-to').val(getUrlParameter('date_to'));
            $('#filter-date-to').attr('type', 'date');
        }
    }

    // Check if there's a specific order by
    var order_by = getUrlParameter('order_by');
    if (order_by)
        $('.filters-sort').val(order_by);

    /*$('html, body').animate({
        scrollTop: $('.search-ajax-button').offset().top
        }, 800);*/
}
