var getHttpRequest = function() {
	var httpRequest = false;

	if (window.XMLHttpRequest) {
		// Mozilla, Safari,...
		httpRequest = new XMLHttpRequest();
		if (httpRequest.overrideMimeType) {
			httpRequest.overrideMimeType('text/xml');
		}
	} else if (window.ActiveXObject) {
		// IE
		try {
			httpRequest = new ActiveXObject('Msxml2.XMLHTTP');
		} catch (e) {
			try {
				httpRequest = new ActiveXObject('Microsoft.XMLHTTP');
			} catch (e) {}
		}
	}

	if (!httpRequest) {
		alert('Abandon :( Impossible de créer une instance XMLHTTP');
		return false;
	}

	return httpRequest;
};

var httpRequest = getHttpRequest();

function createGraphic(arrayLabel, arrayData) {
    const weightCanvas = document.getElementById("weight_canvas");
    const graphicChart = new Chart(weightCanvas, {
    type: "bar",
    data: {
        labels: arrayLabel,
        datasets: [{
            label: 'Kg',
            data: arrayData,
            backgroundColor: [
                "#AF1717"
            ]
        }]
    },
    options: {
        scales: {
            y: {
                tricks: {
                    font: {
                        size : 18
                    }
                }
            },
            x: {
                tricks: {
                    font: {
                        size: 18
                    }
                }
            }
        }
    }
})
}

var arrayAllDate = [];
var arrayAllWeight = [];
function fetchWeight() {
	// Retourne en GET et choisi la fonction a executer
	httpRequest.onreadystatechange = () => {
		if (httpRequest.readyState == 4) {
			allWeight = JSON.parse(httpRequest.response);
			for (let o = 0; o < allWeight.length; o++) {
                arrayAllWeight.push(allWeight[o]['weight'])
                arrayAllDate.push(allWeight[o]['all_date'])
            }
            createGraphic(arrayAllDate, arrayAllWeight)
		}
	};
	httpRequest.open('GET', `../config/fetchAllWeight.php`, true);
	httpRequest.send();
}

fetchWeight();


