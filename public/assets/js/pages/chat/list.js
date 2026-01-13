"use strict";

const cloudapi_id = $('#uuid').val();
const base_url = $('#base_url').val();
const whatsappicon = base_url + '/assets/img/whatsapp.png';

function formatTimestamp2(timestamp) {
  var date = new Date(timestamp);
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // Handle midnight (0 hours)
  var formattedTime = hours + ':' + (minutes < 10 ? '0' : '') + minutes + ' ' + ampm;
  return formattedTime;
}

function updateChatMessages(messageHistoryData) {
  var messageHistoryContainer = $('.chat');
  var currentDate = new Date();
  var currentDay = currentDate.toLocaleString('en-US', { weekday: 'long' });
  var currentYear = currentDate.getFullYear();
  var currentMonth = currentDate.toLocaleString('en-US', { month: 'long' });
var currentDayOfMonth = currentDate.getDate();
  messageHistoryContainer.empty();
  var lastMessageDay = '';
  $.each(messageHistoryData, function(index, message) {
    var messageDate = new Date(message.timestamp);
    var messageDay = messageDate.toLocaleString('en-US', { weekday: 'long' });
    var messageYear = messageDate.getFullYear();
    var messageMonth = messageDate.toLocaleString('en-US', { month: 'long' });
  var messageDayOfMonth = messageDate.getDate();
    if (messageDay !== lastMessageDay) {
      if (messageDay === currentDay && 
        messageYear === currentYear &&
        messageMonth === currentMonth &&
        messageDayOfMonth === currentDayOfMonth ) {
        var conversationStartHTML = '<div class="conversation-start">';
        conversationStartHTML += '<span>Today, ' + formatTimestamp2(message.timestamp) + '</span>';
        conversationStartHTML += '</div>';
        messageHistoryContainer.append(conversationStartHTML);
      } else {
        var conversationStartHTML = '<div class="conversation-start">';
        conversationStartHTML += '<span>' + messageDayOfMonth  + ' ' + messageMonth + ', ' + formatTimestamp2(message.timestamp) + '</span>';
        conversationStartHTML += '</div>';
        messageHistoryContainer.append(conversationStartHTML);
      }
      lastMessageDay = messageDay;
    }
    var messageClass = message.type === 'received' ? 'you' : 'me';
    var html = '<div class="bubble ' + messageClass + '">';
    
    // Check if the message is an image URL
    if (isImageUrl(message.message)) {
var match = message.message.match(/(https?:\/\/\S+)\s*\\n\s*Caption:\s*(.+)/); // Match image URL and caption
  if (!match) {
    // If the initial match failed, try with a single backslash for newline
    match = message.message.match(/(https?:\/\/\S+)\s*\n\s*Caption:\s*(.+)/);
  }

  if (match && match.length === 3) {
    var imageUrl = match[1];
    var caption = match[2];
    html += '<div class="image-container">' +
              '<img style="width:250px;" src="' + imageUrl + '" />' +
              '<p>' + caption + '</p>' +
            '</div>';
  } else {
    // No caption found, display image only
    html += '<img style="width:250px;" src="' + message.message + '" />';
  }
    } else if (isAudioUrl(message.message)) {
      html += '<audio controls><source src="' + message.message + '" type="audio/mpeg"></audio>';
    } else if (isVideoUrl(message.message)) {
      html += '<video style="width: -webkit-fill-available;" controls><source src="' + message.message + '" type="video/mp4"></video>';
    } else if (isPdfOrDocUrl(message.message)) {
        var match = message.message.match(/(https?:\/\/\S+)\s*\\n\s*Caption:\s*(.+)/); 
        if (!match) {
    // If the initial match failed, try with a single backslash for newline
    match = message.message.match(/(https?:\/\/\S+)\s*\n\s*Caption:\s*(.+)/);
    }
    if (match && match.length === 3) {
    var pdfUrl = match[1];
    var caption = match[2];
    html += '<div class="pdf-container">' +
              '<a href="'+pdfUrl+'"><img style="width:250px;" src="../../../assets/img/pdf.png" /></a>' +
              '<p>' + caption + '</p>' +
            '</div>';
  } else {
    
      html += '<a href="' + message.message + '" target="_blank">View Document</a>';
    }
        
    } else {
      html += message.message; // Display text message if not recognized
    }
    
    html += '<span class="armish">'+formatTimestamp2(message.timestamp)+'</span></div>';
    
    messageHistoryContainer.append(html);
  });
  var lastMessage = messageHistoryContainer.find('.bubble:last')[0];
if (lastMessage) {
  lastMessage.scrollIntoView();
}


  // Additional code to handle styling and showing the chat
  messageHistoryContainer.addClass('archat');
  messageHistoryContainer.addClass('active-chat');
  messageHistoryContainer.parents('.chat-system').find('.chat-box .chat-not-selected').hide();
}

function isImageUrl(url) {
  var imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp', '.svg', '.webp'];
  var lowerCaseUrl = url.toLowerCase();
  
  var lines = lowerCaseUrl.split(/\\n|\n|\r\n|\r/);
    var ar = lines.length > 0 ? lines[0] : '';

  var isImage = imageExtensions.some(function(extension) {
    return ar.endsWith(extension);
  });
  
  if (isImage) {
  var hasCaption = /https?:\/\/\S+(\\n|\n)Caption:\s*.+/.test(url);
   return isImage|| hasCaption;
  }
}

function isAudioUrl(url) {
  var audioExtensions = ['.mp3', '.ogg', '.amr', '.wav', '.aac'];
  var lowerCaseUrl = url.toLowerCase();
  
  var lines = lowerCaseUrl.split(/\\n|\n|\r\n|\r/);
    var ar = lines.length > 0 ? lines[0] : '';

  var isAudio = audioExtensions.some(function(extension) {
    return ar.endsWith(extension);
  });

  if (isAudio) {
  var hasCaption = /https?:\/\/\S+(\\n|\n)Caption:\s*.+/.test(url);
   return isAudio || hasCaption;
  }
}

function isVideoUrl(url) {
  var videoExtensions = ['.mp4', '.avi', '.mov', '.mkv'];
  var lowerCaseUrl = url.toLowerCase();
  
  var lines = lowerCaseUrl.split(/\\n|\n|\r\n|\r/);
    var ar = lines.length > 0 ? lines[0] : '';

  var isVideo = videoExtensions.some(function(extension) {
    return ar.endsWith(extension);
  });

  if (isVideo) {
  var hasCaption = /https?:\/\/\S+(\\n|\n)Caption:\s*.+/.test(url);
   return isVideo || hasCaption;
  }

}

function isPdfOrDocUrl(url) {
  var docExtensions = ['.pdf', '.docx', '.doc', '.xls', '.xlsx', '.csv'];
  var lowerCaseUrl = url.toLowerCase();
  
  var lines = lowerCaseUrl.split(/\\n|\n|\r\n|\r/);
    var ar = lines.length > 0 ? lines[0] : '';

  var isDocument = docExtensions.some(function(extension) {
    return ar.endsWith(extension);
  });

  if (isDocument) {
  var hasCaption = /https?:\/\/\S+(\\n|\n)Caption:\s*.+/.test(url);
   return isDocument || hasCaption;
  }
  
  
}

function getChatList() {
var lastUpdateTimestamp = 0;
function updatePreview(key, newMessage, timestamp) {
  const previewSpan = $(`[data-chat="person${key}"] .preview`);
  const timePrev = $(`[data-chat="person${key}"] .user-meta-time`);
  // Update the preview message
  var lastTimestamp = formatTimestamp2(timestamp);
  previewSpan.text(newMessage);
  timePrev.text(lastTimestamp);
}
  function fetchChatMessages() {
    $.ajax({
      type: 'GET',
      url: base_url + '/user/get-chats/' + cloudapi_id,
      dataType: 'json',
      success: function(response) {
        const chats = sortByKey(response, 'updated_at');
        $.each(chats, function(key, item) {
          var key = item.id;
          var messageHistoryData = item.message_history;
          var lastMessage = messageHistoryData[messageHistoryData.length - 1]; // Get the last message from the messageHistoryData array
          var lastTimestamp = formatTimestamp2(lastMessage.timestamp);
          if (item.timestamp > 0) {
            var time = formatTimestamp2(item.timestamp);
            time = `<span class="text-success">${time}</span>`;
          } else {
            var time = '';
          }
          
          var nameOrPhoneNumber = item.name !== null ? item.name : item.phone_number;
          
          var html = `<div class="person" data-chat="person${key}" data-message-history='${JSON.stringify(messageHistoryData)}'>
            <div class="user-info">
              <div class="f-head">
                <img src="${whatsappicon}" alt="avatar">
              </div>
              <div class="f-body">
                <div class="meta-info">
                  <span class="user-name" data-name="${item.phone_number}" data-number="${item.phone_number}">${nameOrPhoneNumber}</span>
                  <span class="user-meta-time">${lastTimestamp}</span>
                </div>
                <span class="preview">${lastMessage.message}</span>
              </div>
              ${time}
            </div>
          </div>`;
         
          
          var messageList = $(`[data-chat="person${key}"].person`);
          if ((item.updated_at && new Date(item.updated_at).getTime() > lastUpdateTimestamp)) {
              updatePreview(key, lastMessage.message, lastMessage.timestamp);
          if (item.updated_at && new Date(item.updated_at).getTime() > lastUpdateTimestamp) {
            lastUpdateTimestamp = new Date(item.updated_at).getTime();
          }
          if (messageList.length > 0) {
    messageList.remove();
        }
        $('.people').prepend(html);
          var flashColor = '#7fffd436';
$('.person:first').css('background', flashColor)
    .delay(500)
    .queue(function (next) {
        $(this).css('background', '');
        next();
    });
          
          }
           if ($(`[data-chat="person${key}"]`).length === 0) {
            $('.people').append(html);
          }
          
          
          
          //next_page = chats.length;
          

          // Update the chat messages for the current chat person
          var messageHistoryContainer = $(`[data-chat="person${key}"]`);
          
          messageHistoryContainer.attr('data-message-history', JSON.stringify(messageHistoryData));

          // Check if this chat is the currently active chat
          if (messageHistoryContainer.hasClass('active-chat')) {
            // Update the chat messages in the "bubble" div
            updateChatMessages(messageHistoryData);
          }
        });
        

        // Call the fetchChatMessages function again after a delay
        setTimeout(fetchChatMessages, 1000); // Fetch messages every seconds
        $('.chat-box-inner').css('height', '100%');
        $('.search > input').on('keyup', function() {
          var rex = new RegExp($(this).val(), 'i');
            $('.people .person').hide();
            $('.people .person').filter(function() {
                return rex.test($(this).text());
            }).show();
        });
        
        $('.user-list-box .person').on('click', function(event) {
            if ($(this).hasClass('.active')) {
                return false;
            } else {
                var findChat = $(this).attr('data-chat');
                var personName = $(this).find('.user-name').text();
                var personImage = $(this).find('img').attr('src');
                var hideTheNonSelectedContent = $(this).parents('.chat-system').find('.chat-box .chat-not-selected').hide();
                var showChatInnerContent = $(this).parents('.chat-system').find('.chat-box .chat-box-inner').show();
        
                if (window.innerWidth <= 767) {
                  $('.chat-box .current-chat-user-name .name').html(personName.split(' ')[0]);
                } else if (window.innerWidth > 767) {
                  $('.chat-box .current-chat-user-name .name').html(personName);
                }
                $('.chat-box .current-chat-user-name img').attr('src', personImage);
                $('.chat').removeClass('active-chat');
                $('.user-list-box .person').removeClass('active');
                $('.chat-box .chat-box-inner').css('height', '100%');
                $(this).addClass('active');
                $('.chat[data-chat = '+findChat+']').addClass('active-chat');
            }
            if ($(this).parents('.user-list-box').hasClass('user-list-box-show')) {
              $(this).parents('.user-list-box').removeClass('user-list-box-show');
            }
            $('.chat-meta-user').addClass('chat-active');
            $('.chat-box').css('height', 'calc(100vh - 100px)');
            $('.chat-footer').addClass('chat-active');
        
          const ps = new PerfectScrollbar('.chat-conversation-box', {
            suppressScrollX : true
          });
        
          const getScrollContainer = document.querySelector('.chat-conversation-box');
          getScrollContainer.scrollTop = 0;
        });
        
        const ps = new PerfectScrollbar('.people', {
          suppressScrollX : true
        });
        
        function callOnConnect() {
          var getCallStatusText = $('.overlay-phone-call .call-status');
          var getCallTimer = $('.overlay-phone-call .timer');
          var setCallStatusText = getCallStatusText.text('IVR Features are coming soon....');
          var setCallTimerDiv = getCallTimer.css('visibility', 'visible');
        }
        
        $('.hamburger, .chat-system .chat-box .chat-not-selected p').on('click', function(event) {
          $(this).parents('.chat-system').find('.user-list-box').toggleClass('user-list-box-show');
        });
        
      },
      error: function(xhr, status, error) {
        if (xhr.status == 500) {
          // Handle error if needed
        }
      }
    });
  }

fetchChatMessages();
  // Call the fetchChatMessages function initially
//});
//console.log(next_page);
}

function downloadMessageHistory(messageHistoryData) {
  // Check if messageHistoryData is defined
  if (messageHistoryData) {
    // Convert the message history data to JSON
    const jsonData = JSON.stringify(messageHistoryData, null, 2); // null, 2 adds indentation for better readability

    // Create a Blob (Binary Large Object) from the JSON data
    const blob = new Blob([jsonData], { type: 'application/json' });

    // Create a download link
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);

    // Set the filename for the downloaded file
    link.download = 'message_history.json';

    // Append the link to the document
    document.body.appendChild(link);

    // Trigger a click on the link to start the download
    link.click();

    // Remove the link from the document
    document.body.removeChild(link);
  } else {
    console.error('No message history data available.');
  }
}
// Attach the download function to the button click event



$(document).ready(function() {
  // Function to handle message form submission
  function sendMessage(event) {
    event.preventDefault(); // Prevent the default form submission

    // Retrieve the form values
    var receiver = $('#receiver').val();
    var message = $('input[name="message"]').val();

    // Perform the AJAX request
    $.ajax({
      url: base_url + '/user/send-message/' + cloudapi_id,
      method: 'POST',
      data: {
        receiver: receiver,
        message: message,
      },
      success: function(response) {
        // Handle the success response
        console.log('Message sent successfully');
        // Reset the message input field
        $('#plain-text').val('');
      },
      error: function(xhr, status, error) {
        // Handle the error response
        console.error(error);
      }
    });
  }

  // Attach event listener to the message form
  $('#chatForm').on('submit', sendMessage);
});

var downloadHandler;

$(document).on('click', '.person', function() {
  var chatId = $(this).data('chat');
  var phone = $(this).find('.user-name').data('number');
  var messageHistoryContainer = $('.chat');
  messageHistoryContainer.attr('data-chat', chatId);
  var messageHistoryData = $(this).data('message-history');
  updateChatMessages(messageHistoryData);
  $('.receiver-number').val(phone);
  
  if (downloadHandler) {
    document.getElementById('downloadButton').removeEventListener('click', downloadHandler);
  }
  downloadHandler = function() {
    downloadMessageHistory(messageHistoryData);
  };
  document.getElementById('downloadButton').addEventListener('click', downloadHandler);
});

// Call the getChatList function initially
getChatList();

function sortByKey(array, key) {
	return array.sort(function(a, b) {
		var x = a[key]; var y = b[key];
		return ((x > y) ? -1 : ((x < y) ? 1 : 0));
	});
}