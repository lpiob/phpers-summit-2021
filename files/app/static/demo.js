function fetchVotes() {
      fetch('/votes.php')
      .then(function(response) {
        return response.json();
      })
      .then(function(myJson) {
        document.getElementById("vote_a").innerHTML=myJson.a;
        document.getElementById("vote_b").innerHTML=myJson.b;
        document.getElementById("worker_loop_time").innerHTML=myJson.worker_loop_time;

        update_chart.data.datasets[0].data.shift();
        update_chart.data.datasets[0].data.push(parseFloat(myJson.worker_loop_time));
        update_chart.update();
        setTimeout(fetchVotes, 990);

      });
}

var update_chart;

document.addEventListener("DOMContentLoaded", function(event){
    fetchVotes();


    update_chart = new Chart(
      document.getElementById('update_chart'), {
              type: 'bar',
              data: {
            labels: Array(50). fill(). map((_, idx) => ""),
        datasets: [{
            label: 'response time',
            data: Array(50). fill(). map((_, idx) => 0),
            borderWidth: 1
        }]                      
              },
              options: {
                      scales: {
                              y: { beginAtZero: true }
                      }
              }
      }
    );
});
