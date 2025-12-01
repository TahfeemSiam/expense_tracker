const noTransactions = document.getElementById('no-tran')
const ctx2 = document.getElementById('myChart2');
const ctx3 = document.getElementById('myChart3');
const dayNumFilter = document.getElementById('date')
const categoryFilter = document.getElementById('category')
const filterBtn = document.querySelector('.filter-btn')

let amounts = []
let category = []

const data = document.querySelector('.json').innerHTML
const jsonData = JSON.parse(data)

if(jsonData.length >= 1) {
    console.log(jsonData)
    for (let i = 0; i < Object.keys(jsonData).length; i++) {
        amounts.push(Object.values(jsonData)[i].amount)
        category.push(Object.values(jsonData)[i].category)
    }
    ctx2.parentElement.classList.remove('display')
    ctx3.parentElement.classList.remove('display')
    noTransactions.parentElement.classList.add('display')
}
else {
    ctx2.parentElement.classList.add('display')
    ctx3.parentElement.classList.add('display')
    noTransactions.parentElement.classList.remove('display')
}

filterBtn.addEventListener('click', function () {
    const dayNum = dayNumFilter.value
    window.location = `user-dashboard.php?num=${dayNum}&category=${categoryFilter.value}`
})

new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: category,
        datasets: [{
            label: 'Bar Plot',
            data: amounts,
            backgroundColor: ["#E6B0AA", "#C39BD3","#7FB3D5","#7DCEA0","#F7DC6F"],
            border: [],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
new Chart(ctx3, {
    type: 'line',
    data: {
        labels: category,
        datasets: [{
            label: 'Line Plot',
            data: amounts,
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});