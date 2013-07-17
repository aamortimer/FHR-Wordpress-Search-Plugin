(function($){
	$(function()	{
	  number_of_months = 1;
	
	  $(document).on("click", ".datepicker", function() {
	    $('.datepicker').attr('readonly', 'true');
	    return $(this).datepicker({
	      showOn: "focus",
	      dateFormat: "dd/mm/yy",
	      minDate: 0,
	      maxDate: "+5y",
	      numberOfMonths: number_of_months,
	      beforeShow: function(input, inst) {
	        if (input.name === "parking-to") {
	          return {
	            minDate: $("input[name=parking-from]").datepicker("getDate")
	          };
	        } else if (input.name === "parking-return") {
	          if ($("#parking-and-hotel-search input[name=hotel-from]")[0]) {
	            return {
	              minDate: $("#parking-and-hotel-search input[name=hotel-from]").datepicker("getDate")
	            };
	          } else {
	            return {
	              minDate: $("#hotel-search input[name=hotel-from]").datepicker("getDate")
	            };
	          }
	        } else {
	          return {
	            minDate: "0"
	          };
	        }
	      },
	      onSelect: function(d, inst) {
	        var da, day, month;
	        if (this.name === "parking-from") {
	          da = d.split("/");
	          d = new Date(da[2], da[1] - 1, da[0]);
	          d.setDate(d.getDate() + 7);
	          day = d.getDate();
	          if (day < 10) {
	            day = "0" + day;
	          }
	          month = (d.getMonth() + 1).toString();
	          if (month.length < 2) {
	            month = "0" + month;
	          }
	          $("input[name=parking-to]").val(day + "/" + month + "/" + d.getFullYear());
	        }
	        if (this.name === "hotel-from") {
	          da = d.split("/");
	          d = new Date(da[2], da[1] - 1, da[0]);
	          d.setDate(d.getDate() + 8);
	          day = d.getDate();
	          if (day < 10) {
	            day = "0" + day;
	          }
	          month = (d.getMonth() + 1).toString();
	          if (month.length < 2) {
	            month = "0" + month;
	          }
	          return $("input[name=parking-return]").val(day + "/" + month + "/" + d.getFullYear());
	        }
	      }
	    }).focus();
	  }); // end datepicker code
	  
	   $(document).on("change", "#lounge_location", function() {
      var lounge_location;
      lounge_location = '';
      if ($(this).val() === "ukLounges") {
        lounge_location = "lounges";
      } else {
        lounge_location = "international";
      }
      
      var url = '/wp-content/plugins/fhr/lounge_airports.php?location='+lounge_location;
      $.get(url, function(data) {
	      $('#lounge-airport').html(data);
      });      
    }); // end lounge locations
	  
	  $('.fhr-form').submit(function(){
		  data = $(this).serialize();
		  p = $(this).find('input[name=p]');
		  p.val(p.val()+'?'+data);
		  console.log(p.val());
	  });
	  
	})
})(jQuery);