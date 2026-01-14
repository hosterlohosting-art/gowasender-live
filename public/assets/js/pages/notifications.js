"use strict";

$.ajaxSetup({
   headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});

let lastUnreadCount = 0;
let firstLoad = true;

function playNotificationSound() {
   var audio = document.getElementById('notificationSound');
   if (audio) audio.play().catch(e => console.log('Audio play blocked', e));
}

function fetchNotifications() {
   $.ajax({
      type: 'POST',
      url: '/user/notifications',

      dataType: 'json',
      contentType: false,
      cache: false,
      processData: false,

      success: function (res) {
         $('.notification-count').html(res.notifications_unread);

         if (res.whatsapp_unread > 0) {
            $('.whatsapp-unread-count').html(res.whatsapp_unread).removeClass('d-none');
         } else {
            $('.whatsapp-unread-count').addClass('d-none');
         }

         // Alert if new notification arrives
         if (res.notifications_unread > lastUnreadCount && !firstLoad) {
            playNotificationSound();

            // Show Toast Notification
            Toastify({
               text: "Hey! You got a new notification 🔔",
               duration: 5000,
               close: true,
               gravity: "top", // `top` or `bottom`
               position: "right", // `left`, `center` or `right`
               backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
               stopOnFocus: true, // Prevents dismissing of toast on hover
               onClick: function () { } // Callback after click
            }).showToast();
         }

         // Update tracking variable
         lastUnreadCount = res.notifications_unread;
         firstLoad = false;

         // Clear existing notifications
         $('.notifications-list').empty();


         $(res.notifications).each(function (index, row) {
            let iconHtml = '<i class="fi fi-rs-bell text-primary"></i>';
            if (row.comment === 'whatsapp-message') {
               iconHtml = '<i class="fab fa-whatsapp text-success" style="font-size: 24px;"></i>';
            }

            var html = `<a href="${row.url}" class="list-group-item list-group-item-action">
                        <div class="row align-items-center">
                           <div class="col-auto">
                              ${iconHtml}
                           </div>
                           <div class="col ml--2">
                              <div class="d-flex justify-content-between align-items-center">
                                 <div>
                                    <h4 class="mb-0 text-sm" style="color: ${row.seen == 0 ? 'green' : 'black'}">${row.title}</h4>
                                 </div>
                                 <div class="text-right text-muted">
                                    <small>${row.updated_at}</small>
                                 </div>
                              </div>
                              <p class="text-sm mb-0">${row.comment != null ? row.comment : ''}</p>
                           </div>
                        </div>
                     </a>`;

            $('.notifications-list').prepend(html);

         });

         res.notifications.length > 0 ? $('.notifications-area').show() : $('.notifications-area').hide();
      },
      error: function (xhr) {

      }
   });
}

fetchNotifications();

// Refresh notifications every 5 seconds (to reduce server load, was 1s)
setInterval(fetchNotifications, 5000);