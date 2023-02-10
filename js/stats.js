function calcAvg(data){
    let sum = 0
    for(let i = 0; i<data.length; i++){
        if(typeof data[i] != "number" ){
            sum += parseInt(data[i]);
        }else{
            sum += data[i];
        }
    }
    let avg = sum / data.length;
    return avg;
}

let dataPoints = [];
let request = new XMLHttpRequest();
request.onreadystatechange = function(){
    if(request.readyState === 4 && request.status === 200){
        console.log(request);
        let data = JSON.parse(request.responseText);
        console.log(data);
        dataPoints.push(data);
        console.log(dataPoints[0])
        // Stat 1
        let cities = Object.keys(dataPoints[0]['stat1']['cities_work_in']);
        let pieData = []
        // let width1 = $('#stat1Chart').width();
        for(let i = 0; i < cities.length; i++){
            pieData.push({y: dataPoints[0]['stat1']['cities_work_in'][cities[i]] , name: cities[i]})
        }
        let stat1Chart = new CanvasJS.Chart("stat1Chart", {
            width: 600,
            height:300,
            animationEnabled: true,
            title: {
                text: "The percentage employed in the high-tech industry by city of residence",
                fontFamily: "'Montserrat', sans-serif",
                fontSize: 20,
                fontWeight: 'bolder'
            },
            axisX: {
                interval: 1,
            },
            axisY: {
                // valueFormatString: "$#0bn",
                gridColor: "#B6B1A8",
                tickColor: "#B6B1A8"
            },
            toolTip: {
                shared: true,
            },
            data: [
                {
                    type: "pie",
                    showInLegend: true,
                    dataPoints: pieData
                }
            ]
        });
        stat1Chart.render();
        // Stat 2
        let stat2Chart = new CanvasJS.Chart("stat2Chart", {
            width: 600,
            height:300,
            animationEnabled: true,
            title: {
                text: "Out of the job seekers, what is the scope of the job requested by age.",
                fontFamily: "'Montserrat', sans-serif",
                fontSize: 20,
                fontWeight: 'bolder'
            },
            axisX: {
                interval: 1,
            },
            axisY: {
                gridColor: "#B6B1A8",
                tickColor: "#B6B1A8"
            },
            toolTip: {
                shared: true,
            },
            data: [
                {
                    type: "stackedColumn",
                    legendText: "Full time",
                    showInLegend: true,
                    dataPoints: [
                        {y: dataPoints[0]['stat2']['18-21']['full_time'] , label: "18-21"},
                        {y: dataPoints[0]['stat2']['22-25']['full_time'], label: "22-25" },
                        {y: dataPoints[0]['stat2']['26-30']['full_time'], label: "26-30" },
                        {y: dataPoints[0]['stat2']['31-35']['full_time'], label: "31-35" },
                        {y: dataPoints[0]['stat2']['36-40']['full_time'], label: "36-40"},
                    ]
                },  {
                    type: "stackedColumn",
                    legendText: "Part time",
                    showInLegend: true,
                    dataPoints: [
                        {y: dataPoints[0]['stat2']['18-21']['part_time'] , label: "18-21"},
                        {y: dataPoints[0]['stat2']['22-25']['part_time'], label: "22-25" },
                        {y: dataPoints[0]['stat2']['26-30']['part_time'], label: "26-30" },
                        {y: dataPoints[0]['stat2']['31-35']['part_time'], label: "31-35" },
                        {y: dataPoints[0]['stat2']['36-40']['part_time'], label: "36-40"},
                    ]
                }
            ]
        });
        stat2Chart.render();
        // Stat 3
        let cities_2 = Object.keys(dataPoints[0]['stat3'])
        let colData = [];
        for(let i = 0; i < cities_2.length; i++){
            colData.push({y: calcAvg(dataPoints[0]['stat3'][cities_2[i]]) ,label: cities_2[i]})
        }
        let stat3Chart = new CanvasJS.Chart("stat3Chart", {
            width: 600,
            height:300,
            animationEnabled: true,
            title: {
                text: "Average salary per hour by city of work",
                fontFamily: "'Montserrat', sans-serif",
                fontSize: 20,
                fontWeight: 'bolder'
            },
            axisX: {
                interval: 1,
            },
            axisY: {
                // valueFormatString: "$#0bn",
                gridColor: "#B6B1A8",
                tickColor: "#B6B1A8"
            },
            toolTip: {
                shared: true,
            },
            data: [
                {
                    type: "column",
                    dataPoints: colData
                }
            ]
        });
        stat3Chart.render();
        // Stat 4
        let stat4_cities = Object.keys(dataPoints[0]['stat4'])
        let stat4Data = []
        for(let i = 0; i < stat4_cities.length; i++){
            stat4Data.push({y: dataPoints[0]['stat4'][stat4_cities[i]], name: stat4_cities[i]})
        }
        let stat4Chart = new CanvasJS.Chart("stat4Chart", {
            width: 600,
            height:300,
            animationEnabled: true,
            title: {
                text: " Search sources among job seekers",
                fontFamily: "'Montserrat', sans-serif",
                fontSize: 20,
                fontWeight: 'bolder'
            },
            axisX: {
                interval: 1,
            },
            axisY: {
                // valueFormatString: "$#0bn",
                gridColor: "#B6B1A8",
                tickColor: "#B6B1A8"
            },
            toolTip: {
                shared: true,
            },
            data: [
                {
                    type: "pie",
                    showInLegend: true,
                    dataPoints: stat4Data
                }
            ]
        });
        stat4Chart.render();
        // Stat 5
        let stat5_source = Object.keys(dataPoints[0]['stat5'])
        let stat5Data = [];
        for(let i = 0; i < stat5_source.length; i++){
            stat5Data.push({y: dataPoints[0]['stat5'][stat5_source[i]], label: stat5_source[i]})
        }
        let stat5Chart = new CanvasJS.Chart("stat5Chart", {
            animationEnabled: true,
            title: {
                text: "Among job seeker users, what are the search sources",
                fontFamily: "'Montserrat', sans-serif",
                fontSize: 20,
                fontWeight: 'bolder'
            },
            axisX: {
                interval: 1,
            },
            axisY: {
                // valueFormatString: "$#0bn",
                gridColor: "#B6B1A8",
                tickColor: "#B6B1A8"
            },
            toolTip: {
                shared: true,
            },
            data: [
                {
                    type: "column",
                    dataPoints: stat5Data
                }
            ]
        });
        stat5Chart.render();
        // Stat 6
        let stat6_exp = Object.keys(dataPoints[0]['stat6']);
        let stat6Data = [];
        for(let i = 0; i < stat6_exp.length; i++){
            stat6Data.push({y: dataPoints[0]['stat6'][stat6_exp[i]], label: stat6_exp[i] === 'experience_avg' ? 'Experienced ' : 'Not experienced'})
        }
        let stat6Chart = new CanvasJS.Chart("stat6Chart", {
            animationEnabled: true,
            title: {
                text: "Average job search time among experienced & not experienced users",
                fontFamily: "'Montserrat', sans-serif",
                fontSize: 20,
                fontWeight: 'bolder'
            },
            axisX: {
                interval: 1,
            },
            axisY: {
                // valueFormatString: "$#0bn",
                gridColor: "#B6B1A8",
                tickColor: "#B6B1A8"
            },
            toolTip: {
                shared: true,
            },
            data: [
                {
                    type: "column",
                    dataPoints: stat6Data
                }
            ]
        });
        stat6Chart.render();
        // Stat 7
        let stat7Chart = new CanvasJS.Chart("stat7Chart", {
            animationEnabled: true,
            title: {
                text: "Acceptance rate among users who prepared & not prepared to the test",
                fontFamily: "'Montserrat', sans-serif",
                fontSize: 20,
                fontWeight: 'bolder'
            },
            axisX: {
                interval: 1,
            },
            axisY: {
                // valueFormatString: "$#0bn",
                gridColor: "#B6B1A8",
                tickColor: "#B6B1A8"
            },
            toolTip: {
                shared: true,
            },
            data: [
                {
                    type: "stackedColumn100",
                    legendText: "Accepted",
                    showInLegend: true,
                    dataPoints: [
                        {y: dataPoints[0]['stat7']['prepared']['accepted'] , label: "Prepared"},
                        {y: dataPoints[0]['stat7']['not_prepared']['accepted'], label: "Not prepared" },
                    ]
                },  {
                    type: "stackedColumn100",
                    legendText: "Not accepted",
                    showInLegend: true,
                    dataPoints: [
                        {y: dataPoints[0]['stat7']['prepared']['not_accepted'] , label: "Prepared"},
                        {y: dataPoints[0]['stat7']['not_prepared']['not_accepted'], label: "Not prepared" },
                    ]
                }
            ]
        });
        stat7Chart.render();
    }
}
request.open('POST', '/phpProject/results/stats.php', true);
request.setRequestHeader('Content-type', 'application/json');
request.send();
console.log(dataPoints);





