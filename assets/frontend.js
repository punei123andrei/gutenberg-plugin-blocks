const $ = jQuery;

$(document).ready(function() {
    $('#sortTable').change(function() {
        var selectedSkill = $(this).val();
        
        $('.tableBlock .rider-row').each(function() {
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
        $('.handler-message').remove();
    
        var formData = $(this).serialize();
        var token = wr_job_obj.token;
    
        var data = {
            action: "wr_insert_post",
            formData: formData,
            token: token
        };
    
        $.ajax({
            url: wr_job_obj.ajaxurl,
            data: data,
            success: function(response) {
              console.log(response.data);
                if (response.data === 'success') {
                    var newRow =`
                    <tr class="rider-row" data-sort="${response.skills}">
                      <td class="post-title"><p>${response.title}</p></td>
                      <td class="first-name"><p>${response.first_name}</p></td>
                      <td class="last-name"><p>${response.last_name}</p></td>
                      <td class="skills"><p>${response.skills}</p></td>
                      <td class="skills"><p>${response.entry_date}</p></td>
                    </tr>
                    `;
                    $('.wr-table-sort tbody').append(newRow);

                    var successMessage = $('<p>', {
                      text: wr_job_obj.translations.formSubmissionSuccess,
                      class: 'handler-message'
                    });
                    $('#wr-job-application').append(successMessage);
                } else {
                    // Post insertion failed
                    var errorMessage = $('<p>', { 
                      text: wr_job_obj.translations.formSubmissionError,
                      class: 'handler-message'
                    });
                    $('#wr-job-application').append(errorMessage);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                var errorMessage = $('<p>', { 
                  text: wr_job_obj.translations.requestProcessingError,
                  class: 'handler-message'
                });
                $('#wr-job-application').append(errorMessage);
            }
        });
    });
});