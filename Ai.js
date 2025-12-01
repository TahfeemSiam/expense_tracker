$(document).ready(function () {
    const chatWindow = document.querySelector('.chat-window')
    const food = document.querySelector('.food').innerHTML
    const travel = document.querySelector('.travel').innerHTML
    const medical = document.querySelector('.medical').innerHTML
    const bills = document.querySelector('.bills').innerHTML
    const electronics = document.querySelector('.electronics').innerHTML
    const income = document.querySelector('.income').innerHTML
    $('#send_msg').click(function () {
        chatWindow.insertAdjacentHTML('beforeend',
            `<div class="d-flex justify-content-end mb-3">
                        <div class="bg-danger text-white p-2 rounded" style="max-width: 75%;">
                            ${$('#user_msg').val()}
                        </div>
                   </div>
                   <div class="waiting d-flex justify-content-start mb-3">
                        <div class="loader"></div>     
                   </div>
                `
                )
        const waiting = document.querySelector('.waiting')

        $.ajax({
            type: "POST",
            url: 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=AIzaSyCBbJNgOv6GhDdcn8IElxaweFkM1F4HXTs',
            contentType: "application/json",
            data: JSON.stringify({
                contents: [
                    { parts: [{ text: `
                     You are a financial advisor agent whose work is to give suggestions using 
                     information on the given json array of strings i have provided and remember every financial suggestions you provide 
                     be based on the context of bangladesh if any questions seems irrelevant just reply i am not an expert on this topic
                     User income: ${income}
                     Json array string of food: ${food}
                     Json array string of medical: ${medical}
                     Json array string of travel: ${travel}
                     Json array string of bills: ${bills}
                     Json array string of electronics: ${electronics}
                     All of this json string of arrays contain average and total amount for each category of item
                     Write your response in a point by point manner for example like this 
                     every suggestion
                     1) first suggestion
                     2) second suggestion
                     .....
                     and so on
                     ${$('#user_msg').val()}` }]
                    }
                ]
            }),
            success: function(response) {
                if(response.candidates[0].content.parts[0].text) {
                    waiting.remove()
                    chatWindow.insertAdjacentHTML('beforeend',
                    `<div class="d-flex justify-content-start mb-3">
                                <div class="bg-primary text-white p-2 rounded" style="max-width: 75%;">
                                    ${response.candidates[0].content.parts[0].text}
                                </div>
                            </div>`
                        )
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error, xhr.responseText);
            }
        });
    })
})