<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Sheets Data Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        .button-container {
            margin-bottom: 20px;
        }
        .year-button {
            padding: 15px 30px;
            margin: 5px;
            cursor: pointer;
            background: linear-gradient(to right, rgb(52, 232, 158), rgb(15, 52, 67));
            border: none;
            border-radius: 50px;
            color: white;
            font-weight: bold;
            font-size: 1.5em;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .year-button:hover {
            background: linear-gradient(to right, rgb(15, 52, 67), rgb(52, 232, 158));
            transform: scale(1.05);
        }
        .Page-Staffs {
            display: flex;
            background: #fff;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        /* .Page-Staffs:nth-child(odd) {
            background-color: #e6f7e6;
        }
        .Page-Staffs:nth-child(even) {
            background-color: #d4edda;
        } */
        .Image-CurveII {
            flex-shrink: 0;
            text-align: center;
            margin-right: 20px;
        }
        .Image-CurveII img {
            max-width: 150px;
            border-radius: 50%;
        }
        .Page-Staffs-Details {
            text-align: left;
            flex-grow: 1;
        }
        .Page-Staffs-Name {
            font-size: 1.5em;
            font-weight: bold;
            color: #008000;
            text-align: left;
        }
        .Page-Staffs-Desc {
            margin: 5px 0;
        }
        .Page-Staffs-Title {
            font-weight: bold;
        }
        .table-section {
            width: 100%;
            border-collapse: collapse;
        }
        .table-section tr:nth-child(odd) {
            background-color: #E0F8E7;
        }
        .table-section tr:nth-child(even) {
            background-color: #ffffff;
        }
        .table-section td {
            padding: 5px;
        }
        .table-section .title {
            width: 150px;
            font-weight: bold;
            text-decoration: underline;
        }
        .ClearBoth-I {
            clear: both;
        }
        @media (max-width: 768px) {
            .Page-Staffs {
                flex-direction: column;
                align-items: center;
            }
            .Image-CurveII {
                margin-right: 0;
                margin-bottom: 20px;
            }
            .Page-Staffs-Details {
                text-align: center;
            }
            .Page-Staffs-Name {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    
    <div class="button-container" id="yearButtons">
        <!-- Buttons will be inserted here -->
    </div>
    <div id="staffContainer"></div>

    <script>
        const apiKey = 'AIzaSyBl85NIvtUbSf4Veaoae8axd-ZQfpR6Pok';
        const spreadsheetId = '14vHGyaQAMFP5tWUOn27TonPy8kEt881EcLk_xhsY1h4';
        const range = 'Sheet1!A2:AI';

        function fetchData() {
            fetch(`https://sheets.googleapis.com/v4/spreadsheets/${spreadsheetId}/values/${range}?key=${apiKey}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.values) {
                        console.error('No data found.');
                        return;
                    }

                    const rows = data.values;
                    const years = Array.from(new Set(rows.map(row => row[2]))).sort(); // Get unique years and sort them
                    const buttonsContainer = document.getElementById('yearButtons');
                    const container = document.getElementById('staffContainer');
                    buttonsContainer.innerHTML = '';
                    container.innerHTML = '';

                    years.forEach(year => {
                        const button = document.createElement('button');
                        button.className = 'year-button';
                        button.textContent = 'Academic year ' + year;
                        button.addEventListener('click', () => displayYearData(year, rows));
                        buttonsContainer.appendChild(button);
                    });

                    // Display data for the first year by default
                    if (years.length > 0) {
                        displayYearData(years[0], rows);
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function displayYearData(year, rows) {
            const container = document.getElementById('staffContainer');
            container.innerHTML = '';

            const yearRows = rows.filter(row => row[2] === year);
            yearRows.forEach(row => {
                const [
                    imageUrl, name, year, program, email, position, specialty, workPlace, thesis,
                    majorAdvisor, coAdvisor1, coAdvisor2, coAdvisor3, coAdvisor4, interests,
                    publication1, linkPub1, publication2, linkPub2, publication3, linkPub3,
                    publication4, linkPub4, publication5, linkPub5, publication6, linkPub6
                ] = row;

                const staffDiv = document.createElement('div');
                staffDiv.className = 'Page-Staffs';
                staffDiv.innerHTML = `
                    <div class="Image-CurveII">
                        <img alt="alt" src="${imageUrl}" title="title" />
                    </div>
                    <div class="Page-Staffs-Details">
                        <div class="Page-Staffs-Name">${name}</div>
                        <hr>
                        <table class="table-section">
                            <tr>
                                <td class="title"><u>Academic year</u> :</td>
                                <td>${year}</td>
                            </tr>
                            <tr>
                                <td class="title"><u>Program</u> :</td>
                                <td>${program}</td>
                            </tr>
                            <tr>
                                <td class="title"><u>Email</u> :</td>
                                <td>${email}</td>
                            </tr>
                            <tr>
                                <td class="title"><u>Position</u> :</td>
                                <td>${position}</td>
                            </tr>
                            <tr>
                                <td class="title"><u>Specialty</u> :</td>
                                <td>${specialty}</td>
                            </tr>
                            <tr>
                                <td class="title"><u>Place of work</u> :</td>
                                <td>${workPlace}</td>
                            </tr>
                            <tr>
                                <td class="title"><u>Thesis</u> :</td>
                                <td>${thesis}</td>
                            </tr>
                            <tr>
                                <td class="title"><u>Major Advisor</u> :</td>
                                <td>${majorAdvisor}</td>
                            </tr>
                            <tr>
                                <td class="title"><u>Co-Advisor</u> :</td>
                                <td>
                                    ${coAdvisor1 ? `${coAdvisor1}` : ''}
                                    ${coAdvisor2 ? `<br>${coAdvisor2}` : ''}
                                    ${coAdvisor3 ? `<br>${coAdvisor3}` : ''}
                                    ${coAdvisor4 ? `<br>${coAdvisor4}` : ''}
                                </td>
                            </tr>
                            <tr>
                                <td class="title"><u>Publication/<br>Conference</u> :</td>
                                <td>
                                    ${publication1 ? `<a href="${linkPub1}" target="_blank">${publication1}</a>` : ''}
                                    ${publication2 ? `<br><br><a href="${linkPub2}" target="_blank">${publication2}</a>` : ''}
                                    ${publication3 ? `<br><br><a href="${linkPub3}" target="_blank">${publication3}</a>` : ''}
                                    ${publication4 ? `<br><br><a href="${linkPub4}" target="_blank">${publication4}</a>` : ''}
                                    ${publication5 ? `<br><br><a href="${linkPub5}" target="_blank">${publication5}</a>` : ''}
                                    ${publication6 ? `<br><br><a href="${linkPub6}" target="_blank">${publication6}</a>` : ''}
                                </td>
                            </tr>
                            <tr>
                                <td class="title"><u>Areas of interest</u> :</td>
                                <td>${interests}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="ClearBoth-I">&nbsp;</div>
                `;

                container.appendChild(staffDiv);
            });
        }

        document.addEventListener('DOMContentLoaded', fetchData);
    </script>
</body>
</html>
