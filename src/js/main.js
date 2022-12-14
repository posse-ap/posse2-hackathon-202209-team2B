'use strict'
const openModalClassList = document.querySelectorAll('.modal-open')
const closeModalClassList = document.querySelectorAll('.modal-close')
const overlay = document.querySelector('.modal-overlay')
const body = document.querySelector('body')
const modal = document.querySelector('.modal')
const modalInnerHTML = document.getElementById('modalInner')
const topAccordion = document.getElementById('topAccordion')


jQuery(function ($ , e) {
  $('.js-accordion-title').on('click', function () {
    /*クリックでコンテンツを開閉*/
    $(this).next().slideToggle(200);
    /*矢印の向きを変更*/
    $(this).toggleClass('open', 200);
  });
  });

for (let i = 0; i < openModalClassList.length; i++) {
  openModalClassList[i].addEventListener('click', (e) => {
    e.preventDefault()
    let eventId = parseInt(e.currentTarget.id.replace('event-', ''))
    openModal(eventId)
  }, false)
}

for (var i = 0; i < closeModalClassList.length; i++) {
  closeModalClassList[i].addEventListener('click', closeModal)
}

// overlay.addEventListener('click', closeModal)


async function openModal(eventId) {
  try {
    const url = '/api/getModalInfo.php?eventId=' + eventId
    const res = await fetch(url)
    const event = await res.json()
    console.log(event.eventStatus[0]);
    console.log(event.attendanceUser);
    let participation = event.eventStatus[0].participation;
    let nonparticipation = event.eventStatus[0].nonparticipation;
    let notsubmitted = event.eventStatus[0].notsubmitted;

    let modalHTML = `
      <h2 class="text-md font-bold mb-3">${event.name}</h2>
      <p class="text-sm">${event.date}（${event.day_of_week}）</p>
      <p class="text-sm">${event.start_at} ~ ${event.end_at}</p>

      <hr class="my-4">

      <p class="text-md">
        ${event.message}
      </p>

      <hr class="my-4">
      <section class="accordion">
      <input id="block-01" type="checkbox" class="toggle">
      <label class="Label" for="block-01"><p class="text-sm"><span class="text-xl">${event.attendanceUser.length}</span>人参加 ></p></label>
      <div class="content">
    `
    event.attendanceUser.forEach(function(element, index, array){
      modalHTML += `<p class="text-sm">` + element['name'] + `</p>`
    });

    switch (0) {
      case 0:
        modalHTML += `
        </div>
          <div class="text-center mt-6">
            <!--
            <p class="text-lg font-bold text-yellow-400">未回答</p>
            <p class="text-xs text-yellow-400">期限 ${event.deadline}</p>
            -->
          </div>
        `
        if (participation == 1) {
          modalHTML += `<div class="flex mt-5">
        <button class="flex-1 bg-blue-500 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId})" disabled>参加する</button>
        <button class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="nonparticipateEvent(${eventId})">参加しない</button>
      </div>`
      }else if( nonparticipation == 1){
        modalHTML += `<div class="flex mt-5">
        <button class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId})">参加する</button>
        <button class="flex-1 bg-blue-500 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="nonparticipateEvent(${eventId})" disabled>参加しない</button>
      </div>`
      }else{ modalHTML += `<div class="flex mt-5">
      <button class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId})">参加する</button>
      <button class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="nonparticipateEvent(${eventId})">参加しない</button>
    </div>`}

        break;
      case 1:
        modalHTML += `
          <div class="text-center mt-10">
            <p class="text-xl font-bold text-gray-300">不参加</p>
          </div>
        `
        break;
      case 2:
        modalHTML += `
          <div class="text-center mt-10">
            <p class="text-xl font-bold text-green-400">参加</p>
          </div>
        `
        break;
    }
    modalInnerHTML.insertAdjacentHTML('afterbegin', modalHTML)
  } catch (error) {
    console.log(error)
  }
  toggleModal()
}

function closeModal() {
  modalInnerHTML.innerHTML = ''
  toggleModal()
}

function toggleModal() {
  modal.classList.toggle('opacity-0')
  modal.classList.toggle('pointer-events-none')
  body.classList.toggle('modal-active')
}

async function participateEvent(eventId) {
  try {
    let formData = new FormData();
    formData.append('eventId_0', eventId)
    const url = '/api/postEventAttendance.php'
    await fetch(url, {
      method: 'POST',
      body: formData
    }).then((res) => {
      if (res.status !== 200) {
        throw new Error("system error");
      }
      return res.text();
    })
    closeModal()
    location.reload()
  } catch (error) {
    console.log(error)
  }
}

async function nonparticipateEvent(eventId) {
  try {
    let formData = new FormData();
    formData.append('eventId_1', eventId)
    const url = '/api/postEventAttendance.php'
    await fetch(url, {
      method: 'POST',
      body: formData
    }).then((res) => {
      if (res.status !== 200) {
        throw new Error("system error");
      }
      return res.text();
    })
    closeModal()
    location.reload()
  } catch (error) {
    console.log(error)
  }
}




