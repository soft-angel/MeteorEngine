<script type='text/javascript'>
function GoTo(url, frame){
	$(frame).attr("src", url);
}
    var pathObj = {
        "stata": {
            "strokepath": [
                {
                    "path": "M597.851,251.188H489.531c-7.418,0-13.325,5.907-13.325,13.325v281.891h-46.707V112.44c0-7.418-5.907-13.325-13.325-13.325   H307.099c-7.418,0-13.325,5.907-13.325,13.325V547.16h-46.707V337.252c0-7.418-5.907-13.325-13.325-13.325H124.598   c-7.418,0-13.325,5.907-13.325,13.325V547.16H83.111c-0.756,0-0.756,0-1.511,0c0,0-5.22,0-8.174-2.954   c-3.709-2.953-4.465-9.616-4.465-14.836V56.048c0-7.418-5.907-13.325-13.325-13.325H13.325C5.907,42.723,0,48.63,0,56.048   s5.907,13.325,13.325,13.325h28.917v60.17H13.325C5.907,129.543,0,135.45,0,142.869c0,7.418,5.907,13.325,13.325,13.325h28.917   v60.101H13.325C5.907,216.295,0,222.202,0,229.62c0,7.418,5.907,13.325,13.325,13.325h28.917v60.101H13.325   C5.907,303.046,0,308.953,0,316.372c0,7.418,5.907,13.325,13.325,13.325h28.917v60.17H13.325C5.907,389.867,0,395.774,0,403.192   c0,7.418,5.907,13.325,13.325,13.325h28.917v60.101H13.325C5.907,476.618,0,482.525,0,489.943s5.907,13.325,13.325,13.325h28.917   v20.743c0,15.592,4.465,27.475,13.325,35.58c9.616,8.174,20.743,9.616,25.964,9.616c0.756,0,2.198,0,2.198,0h41.556h108.319h74.182   h108.319h74.182h108.319c7.418,0,13.325-5.907,13.325-13.325V265.269C611.245,257.095,605.269,251.188,597.851,251.188z    M138.679,547.16V350.578h80.844v195.826h-80.844V547.16z M321.18,547.16V125.834h80.844v420.638H321.18V547.16z M503.681,547.16   V278.594h80.844V547.16H503.681z",
                    "duration": 12000
                }
            ],
            "dimensions": {
                "width": 612,
                "height": 612
            }
        }
    }; 

</script><!-- Навешивание скринов урл -->
<?php if($Stata->config["screenshots"] == 'Y'){?>

<?php } ?>
<!-- Конец навешивание скринов урл -->
<!-- Навешивание подсказок -->
<script>
$(document).ready(function () {
	$('#stata').lazylinepainter(
	{
		"svgData": pathObj,
		"strokeWidth": 7,
		"strokeColor": "#1fbba6"
	}).lazylinepainter('paint'); 
	
    $.scrollbar({
        scrollpane:    $('.left_list'), // parent element
        scrollcontent: $('.left_list ul')  // inner content
    });
    $.scrollbar({
        scrollpane:    $('.right_list'), // parent element
        scrollcontent: $('.right_list ul')  // inner content
    });
    $('u[title]').qtip({position:{ my: 'top center', at: 'bottom center'}});
    $('a[title]').qtip({position:{ my: 'top center', at: 'bottom center'}});
	$('p[title]').qtip({position:{ my: 'top center', at: 'bottom center'}});
	$('img[title]').qtip({position:{ my: 'top center', at: 'bottom center'}});
	$('div[title]').qtip({position:{ my: 'top center', at: 'bottom center'}});
	$('span[title]').qtip({position:{ my: 'top center', at: 'bottom center'}});
	$('i[title]').qtip({position:{ my: 'top center', at: 'bottom center'}});
	// Crрины сайтов
	$('a[data-href]').mouseleave(function() {
    var url = encodeURIComponent( $(this).attr('data-href') ),
        apiKey = '0KUn7MSO3322',
        thumbail;
    thumbnail = $('<img />', {
        src: 'http://mini.s-shot.ru/?' + url,
        alt: 'Загрузка скрина...',
        width: 202,
        height: 152
    });

    if($(this).qtip({
        content: thumbnail,
        position: {
            at: 'bottom center',
            my: 'top center'
        },
        style: {
            classes: 'websnapr qtip-blue'
        }
    })){
		$(this).hover();
	}
});
});
</script>
<!-- Конец навешивание подсказок -->