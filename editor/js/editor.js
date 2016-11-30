$(window).on('load', function () {

  $('button#add-shownote').click(function () {
    if ($('#inputNoteTitle').val() == '' || $('#inputNoteUrl').val() == '') {
      alert('Title and Description are both required');
      return;
    }

    // Copy the Title, URL and Description to the hidden fields and give them IDs.
    $('#newNoteTitle')
      .val($('#addNoteTitle').val())
      .attr('name', 'note_title[]')
      ;
    $('#newNoteUrl')
      .val($('#addNoteUrl').val())
      .attr('name', 'note_link[]')
      ;
    $('#newNoteDescription')
      .val($('#addNoteDescription').val())
      .attr('name', 'note_description[]')
      ;

    new_fields = $('#new-shownote-template .new-shownote-template')
      .clone()
      .prependTo('.append-show-notes');

    // Clear the add shownote fields.
    $('#addNoteTitle').val('');
    $('#addNoteUrl').val('');
    $('#addNoteDescription').val('');

    // Remove the IDs from the template.
    $('#newNoteTitle').attr('name', '');
    $('#newNoteUrl').attr('name', '');
    $('#newNoteDescription').attr('name', '');

  });

  $('#checkMediaUrl').click(function () {
    $.ajax({
		type: 'GET',
		async: true,
		url: "get_headers.php?url=" + $('#inputMediaURL').val(),
    }).done(function (message, text, jqXHR) {
      if ('HTTP/1.1 200 OK' == message[0]) {
        $('#inputMediaLength').val('');
        $('#inputMediaType').val('');
      	// Parse the headers.
        for (i = 1; i < message.length; i++) {
          bits = message[i].split(': ');
          switch (bits[0]) {
            case 'Content-Length':
              $('#inputMediaLength').val(bits[1]);
              break;

            case 'Content-Type':
              $('#inputMediaType').val(bits[1]);
              break;
          }
        }
      } else {
      	alert('Unexpected response: ' + message[0]);
      }
    });
  });
});
