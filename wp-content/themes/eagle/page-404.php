<?php ?>
<div class="404Wrapper">
    <div class="PageNotFoundContainer Main">
        <h2>Oops.... This page doesn't exist.</h2>
        <p>Don't worry. It happens to everyone.</p>
        <h2><a data-category="pp-404" data-action="link" data-label="home" href="http://www.perfectpickem.com"><span style="color:#fc4349;">Click here</span></a> to return back to the home page.</h2>
        <img class="punter-fail" src="<?php echo $directory; ?>/images/punter-fail.gif" style="display:none"/>
    </div>
    <script>
    $(document).ready(function(e) {
       $(".404Wrapper .FooterContainer").css("top", "70px");
       $(".404Wrapper .punter-fail").show();
    });
    </script>
</div>
