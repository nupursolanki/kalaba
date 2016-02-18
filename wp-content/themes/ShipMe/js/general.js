 jQuery(document).ready(function () {
//alert(11);
            jQuery('.view-beading-detail').click(function () {
        //alert(11);
            jQuery(this).closest('.post-jb').find('.bidding-detail-area').slideDown();
            });
            jQuery('.close_bedding_panel').click(function () {
        //alert(11);
            jQuery(this).closest('.post-jb').find('.bidding-detail-area').slideUp();
            });
     

   

        });