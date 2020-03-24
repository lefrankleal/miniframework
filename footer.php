</div>
</div>
<!-- Here goes all the global vars you want to extract from the backend mostly used for LANG behaviour -->
<script type="text/javascript">
    var LANG = '<?php echo LANG ?>';
    var URL = '<?php echo URL ?>';
</script>
<!-- google web fonts -->
<script>
    WebFontConfig = {
        google: {
            families: [
                'Source+Code+Pro:400,700:latin',
                'Roboto:400,300,500,700,400italic:latin'
            ]
        }
    };
    (function () {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();
</script>

<!-- Here goes your global js files -->

<?php
$min = ENV == 'prod' ? '.min' : '';
if (file_exists("assets/js/pages/" . PAGE . $min . ".js") && is_readable("assets/js/pages/" . PAGE . $min . ".js")) {
    echo '<script src="/assets/js/pages/' . PAGE . $min . '.js"></script>';
}
?>
</body>
</html>