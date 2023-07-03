const $ = jQuery;

$(document).ready(function() {
    $('#sortTable').change(function() {
        var selectedSkill = $(this).val();
        
        $('.tableBlock .container-flex').each(function() {
          var dataSort = $(this).data('sort');
          var skillsArray = dataSort.split(' ');
    
          if (skillsArray.indexOf(selectedSkill) === -1) {
            $(this).hide();
          } else {
            $(this).show();
          }
        });
      });

      $('#wr-job-application').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var token = wr_job_obj.token;

        var data = {
          action: "wr_send_email",
          formData: formData,
          token: token
        }
        $.ajax({
          url: wr_job_obj.ajaxurl,
          data: data,
          success: function(response) {
            // Handle the response from the server
            console.log(response);
          },
          error: function(xhr, status, error) {
            // Handle errors
            console.log(error);
          }
        });
      });
});