 $(document).ready(function () {
//alert(11);
            $('.view-beading-detail').click(function () {
        //alert(11);
            $(this).closest('.post-jb').find('.bidding-detail-area').slideDown();
            });
            $('.close_bedding_panel').click(function () {
        //alert(11);
            $(this).closest('.post-jb').find('.bidding-detail-area').slideUp();
            });
     

        });