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
  var messageHistoryContainer = $('.chatting-container');
  var currentDate = new Date();
  var currentDay = currentDate.toLocaleString('en-US', { weekday: 'long' });
  var currentYear = currentDate.getFullYear();
  var currentMonth = currentDate.toLocaleString('en-US', { month: 'long' });
  var currentDayOfMonth = currentDate.getDate();
  messageHistoryContainer.empty();
  var lastMessageDay = '';
  $.each(messageHistoryData, function (index, message) {
    var messageDate = new Date(message.timestamp);
    var messageDay = messageDate.toLocaleString('en-US', { weekday: 'long' });
    var messageYear = messageDate.getFullYear();
    var messageMonth = messageDate.toLocaleString('en-US', { month: 'long' });
    var messageDayOfMonth = messageDate.getDate();
    if (messageDay !== lastMessageDay) {
      if (messageDay === currentDay &&
        messageYear === currentYear &&
        messageMonth === currentMonth &&
        messageDayOfMonth === currentDayOfMonth) {
        var conversationStartHTML = '<div class="chatting-time">';
        conversationStartHTML += '<span>Today, ' + formatTimestamp2(message.timestamp) + '</span>';
        conversationStartHTML += '</div>';
        messageHistoryContainer.append(conversationStartHTML);
      } else {
        var conversationStartHTML = '<div class="chatting-time">';
        conversationStartHTML += '<span>' + messageDayOfMonth + ' ' + messageMonth + ', ' + formatTimestamp2(message.timestamp) + '</span>';
        conversationStartHTML += '</div>';
        messageHistoryContainer.append(conversationStartHTML);
      }
      lastMessageDay = messageDay;
    }
    var messageClass = message.type === 'received' ? 'other-chat-container' : 'own-chat-container';
    var messageClass2 = message.type === 'received' ? 'other-chat' : 'own-chat';
    var messageClass3 = message.type === 'received' ? 'other-time' : 'own-time';
    var html = '<div class="bubble ' + messageClass + '">';
    var html = '<div class="' + messageClass + '"><div class="' + messageClass2 + '">'


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
          '<a href="' + pdfUrl + '"><img style="width:250px;" src="../../../assets/img/pdf.png" /></a>' +
          '<p>' + caption + '</p>' +
          '</div>';
      } else {

        html += '<a href="' + message.message + '" target="_blank">View Document</a>';
      }

    } else {
      html += '<p>' + message.message + '</p>'; // Display text message if not recognized
    }

    html += '</div><span class="' + messageClass3 + '">' + formatTimestamp2(message.timestamp) + '</span></div>';

    messageHistoryContainer.append(html);
  });
  var lastMessage = messageHistoryContainer.find('.other-chat-container, .own-chat-container').last()[0];
  if (lastMessage) {
    lastMessage.scrollIntoView();
  }


  // Additional code to handle styling and showing the chat
  messageHistoryContainer.addClass('archat');
  messageHistoryContainer.addClass('active-chat');

}

function isImageUrl(url) {
  var imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp', '.svg', '.webp'];
  var lowerCaseUrl = url.toLowerCase();

  var lines = lowerCaseUrl.split(/\\n|\n|\r\n|\r/);
  var ar = lines.length > 0 ? lines[0] : '';

  var isImage = imageExtensions.some(function (extension) {
    return ar.endsWith(extension);
  });

  if (isImage) {
    var hasCaption = /https?:\/\/\S+(\\n|\n)Caption:\s*.+/.test(url);
    return isImage || hasCaption;
  }
}

function isAudioUrl(url) {
  var audioExtensions = ['.mp3', '.ogg', '.amr', '.wav', '.aac'];
  var lowerCaseUrl = url.toLowerCase();

  var lines = lowerCaseUrl.split(/\\n|\n|\r\n|\r/);
  var ar = lines.length > 0 ? lines[0] : '';

  var isAudio = audioExtensions.some(function (extension) {
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

  var isVideo = videoExtensions.some(function (extension) {
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

  var isDocument = docExtensions.some(function (extension) {
    return ar.endsWith(extension);
  });

  if (isDocument) {
    var hasCaption = /https?:\/\/\S+(\\n|\n)Caption:\s*.+/.test(url);
    return isDocument || hasCaption;
  }


}
var currentPhoneNumber;
function getChatList() {
  // Function to fetch chat messages
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
      success: function (response) {
        const chats = sortByKey(response, 'updated_at');
        $.each(chats, function (index, item) {
          var key = item.id;
          var messageHistoryData = item.message_history;
          var lastMessage = messageHistoryData[messageHistoryData.length - 1];
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
              <div class="user-head mr-2">
                <img src="${whatsappicon}" alt="avatar">
              </div>
                <div class="user-body">
                    <h5 class="text-truncate strong mb-0 mt-1 chat-user-name" data-name="${item.phone_number}" data-number="${item.phone_number}">${nameOrPhoneNumber}</span>
                    <p class="text-muted font-11 text-truncate mb-0 preview">${lastMessage.message}</p>
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

          var messageHistoryContainer = $(`[data-chat="person${key}"]`);

          messageHistoryContainer.attr('data-message-history', JSON.stringify(messageHistoryData));

          // Check if this chat is the currently active chat
          if (messageHistoryContainer.hasClass('active-chat')) {
            // Update the chat messages in the "bubble" div
            updateChatMessages(messageHistoryData);
          }


        });
        setTimeout(fetchChatMessages, 1000);
        $('.chat-box-inner').css('height', '100%');

        $(document).ready(function () {
          $('.user-list-box .search > input').on('keyup', function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.people .person').hide();
            $('.people .person').filter(function () {
              return rex.test($(this).text());
            }).show();
          });
        });

        $('.user-list-box .person, .team-container .single-team').on('click', function (event) {
          if ($(this).hasClass('.active')) {
            return false;
          }
          else {

            var findChat = $(this).attr('data-chat');
            var personName = $(this).find('.chat-user-name').text();
            var personImage = $(this).find('img').attr('src');
            var number = $(this).find('.chat-user-name').data('number');
            currentPhoneNumber = number;
            var hideTheNonSelectedContent = $(this).parents('.chat-system').find('.chat-box .chat-not-selected').hide();
            var showChatInnerContent = $(this).parents('.chat-system').find('.chat-box .chat-box-inner').show();
            $('.user-list-box .person').removeClass('active');
            $(this).addClass('active');
            $('.chat-details').fadeIn();
            $('.chat-user-details').fadeIn();
            $('.chat-details.empty').addClass('d-none');
            $('.chatting-container[data-chat = ' + findChat + ']').addClass('active-chat');
            const getScrollContainer = document.querySelector('.chatting-container'); //Scroll bottom when chat initiate
            getScrollContainer.scrollTop = getScrollContainer.scrollHeight;

            if (window.innerWidth <= 767) {
              $('.chat-with-name').html(personName.split(' ')[0]);
              $('.chat-system').addClass('is-chat-active'); // Add active class for mobile
            } else if (window.innerWidth > 767) {
              $('.chat-with-name').html(personName.split(' ')[0]);
              $('.chat-number').html(number);
            }
          }

          $('.hamburger').children().removeClass('la-times');
          $('.hamburger').children().addClass('la-bars');
          $('.chat-container .user-container').removeClass('opened');
          toggleHumburger = !toggleHumburger;
        });

        // Handler for Back Button on Mobile
        $(document).on('click', '.go-back-chat', function () {
          $('.chat-system').removeClass('is-chat-active');
          $('.chat-box .chat-box-inner').hide();
          $('.chat-box .chat-not-selected').show();
          // Optional: Remove active state from person
          $('.user-list-box .person').removeClass('active');
        });

        $('.chat-with').on('click', function (event) {
          $('.chat-user-details').addClass('visible');
        });
        $('.hide-chat-user-details').on('click', function (event) {
          $(this).parents('.chat-user-details').removeClass('visible');
        });

        var toggleHumburger;
        $('.hamburger').on('click', function (event) {
          toggleHumburger = !toggleHumburger;
          if (toggleHumburger) {
            $(this).children().removeClass('la-bars');
            $(this).children().addClass('la-times');
            $('.chat-container .user-container').addClass('opened');
          } else {
            $(this).children().removeClass('la-times');
            $(this).children().addClass('la-bars');
            $('.chat-container .user-container').removeClass('opened');
          }
        })


      },

      error: function (xhr, status, error) {
        // Handle errors if needed
        if (xhr.status == 500) {
          console.error("Error fetching chat messages:", error);
        }
      },
    });
  }

  // Call the fetchChatMessages function initially
  fetchChatMessages();
}
function downloadMessageHistory(messageHistoryData) {
  if (messageHistoryData) {
    const jsonData = JSON.stringify(messageHistoryData, null, 2);
    const blob = new Blob([jsonData], { type: 'application/json' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'message_history.json';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  } else {
    console.error('No message history data available.');
  }
}


$(document).ready(function () {
  // Flag to check if AJAX request is in progress
  var isSendingMessage = false;

  // Attach event listener for sending messages when "Enter" is pressed in the input field
  $('.chat-text-input').on('keydown', function (event) {
    if (event.key === 'Enter') {
      sendMessage();
    }
  });

  // Attach event listener for sending messages when the send button is clicked
  $('.chat-send').on('click', function (event) {
    sendMessage();
  });

  // Function to send a message
  function sendMessage() {
    // Check if the previous AJAX request is still in progress
    if (isSendingMessage) {
      return;
    }
    var receiver = $('#receiver').val();
    var dt = new Date();
    var time = dt.getHours() + ":" + dt.getMinutes();
    var chatInput = $('.chat-text-input');
    var chatInputMessage = chatInput.val();

    var formData = new FormData();
    formData.append('receiver', receiver);
    formData.append('message', chatInputMessage);
    if (chatInputMessage === '') {
      chatInput.addClass('border border-danger');
      return;
    } else {
      var $messageHtml = '<div class="own-chat-container slideInRight"><div class="own-chat"><p>' + chatInputMessage + '</p></div><span class="own-time">' + time + '</span></div>';
      $('.chatting-container').append($messageHtml);
      const getScrollContainer = document.querySelector('.chatting-container');
      getScrollContainer.scrollTop = getScrollContainer.scrollHeight;

      // Set the flag to indicate that the AJAX request is in progress
      isSendingMessage = true;

      // Perform the AJAX request
      $.ajax({
        url: base_url + '/user/send-message/' + cloudapi_id,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          // Handle the success response
          console.log('Message sent successfully');
        },
        error: function (xhr, status, error) {
          // Handle the error response
          console.error(error);
        },
        complete: function () {
          // Set the flag to indicate that the AJAX request is complete
          isSendingMessage = false;
        }
      });

      if (chatInput.hasClass('border border-danger')) {
        chatInput.removeClass('border border-danger');
      }
      chatInput.val('');
    }
  }
});


var downloadHandler;
$(document).on('click', '.person', function () {
  var chatId = $(this).data('chat');
  var phone = $(this).find('.chat-user-name').data('number');
  $('#phone').val(phone);
  var messageHistoryContainer = $('.chatting-container');
  messageHistoryContainer.attr('data-chat', chatId);
  var messageHistoryData = $(this).data('message-history');
  updateChatMessages(messageHistoryData);
  $('.receiver-number').val(phone);
  if (downloadHandler) {
    document.getElementById('downloadButton').removeEventListener('click', downloadHandler);
  }
  downloadHandler = function () {
    downloadMessageHistory(messageHistoryData);
  };
  document.getElementById('downloadButton').addEventListener('click', downloadHandler);

  const ps = new PerfectScrollbar('.people', {
    suppressScrollX: true
  });
  const cs = new PerfectScrollbar('.chatting-container', {
    suppressScrollX: true
  });

});
getChatList();

function sortByKey(array, key) {
  return array.sort(function (a, b) {
    var x = a[key]; var y = b[key];
    return ((x > y) ? -1 : ((x < y) ? 1 : 0));
  });
}
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('clear-chat').addEventListener('click', function () {
    var phone = $(this).find('.chat-user-name').data('number');
    if (confirm('Are you sure you want to clear all messages except the first one?')) {
      $.ajax({
        url: base_url + '/user/clear-messages/' + cloudapi_id,
        type: 'POST',
        data: {
          phone: currentPhoneNumber
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
          if (response.status === 'success') {
            alert('Messages cleared successfully, except the first one.');
            // Add logic to update the chat UI if necessary
          } else {
            alert('Failed to clear messages: ' + response.message);
          }
        },
        error: function (xhr) {
          console.error('Error clearing messages:', xhr.responseJSON.message);
          alert('An error occurred while clearing messages.');
        }
      });
    }
  });
});


