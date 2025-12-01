$(document).ready(function () {
    $('#transaction').submit(function(e) {
        e.preventDefault();
        const amount = document.getElementById('amount').value
        const category = document.getElementById('catg').value
        const date = document.getElementById('date').value
        $.ajax({
            'type': "POST",
            'url': 'process.php',
            'data': {
                amount: amount,
                category: category,
                date: date
            },
            'success': function(response)
            {
                document.querySelector('.tr-success').classList.remove('display')
                setTimeout( () => {
                    document.querySelector('.tr-success').classList.add('display')
                }, 2000)
            },
            'error': function(xhr, status, error) {
                console.error("AJAX Error:", status, error, xhr.responseText);
            }
        });
    });

    // $('#stripe_transaction').submit(function(e) {
    //     e.preventDefault();
    //     const amount = document.getElementById('s_amount').value
    //     const category = document.getElementById('s_catg').value
    //     const date = document.getElementById('s_date').value
    //     const quantity = document.getElementById('qty').value
    //     $.ajax({
    //         'type': "POST",
    //         'url': 'process.php',
    //         'data': {
    //             s_amount: amount,
    //             s_catg: category,
    //             s_date: date,
    //             qty: quantity
    //         },
    //         'success': function(response)
    //         {
    //             console.log('Payment Made Successfully')
    //         },
    //         'error': function(xhr, status, error) {
    //             console.error("AJAX Error:", status, error, xhr.responseText);
    //         }
    //     });
    // });
});