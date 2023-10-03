<? include('config.php');


$query = "SELECT v.id,v.vendorName, COUNT(s.delegatedToVendorId) AS siteAllocated, 
          COALESCE(SUM(s.delegatedByVendor = 1), 0) AS assignEngineer,
          COALESCE(SUM(s.isFeasibiltyDone = 1), 0) AS feasibiltyDone
          FROM vendor v
          LEFT JOIN sites s ON v.id = s.delegatedToVendorId
          GROUP BY v.id";
$result = mysqli_query($con, $query);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {

$vendorId = $row['id'];
$query4 = mysqli_query($con,"SELECT COUNT(DISTINCT siteid) AS count FROM material_requests WHERE status='pending' AND isProject=1 and vendorId='".$vendorId."'");
$query4_result = mysqli_fetch_assoc($query4);
$materialRequest = $query4_result['count'];

$query5 = mysqli_query($con,"SELECT COUNT(1) AS count FROM material_send where vendorId='".$vendorId."'");
$query5_result = mysqli_fetch_assoc($query5);
$materialSend = $query5_result['count']; 


    $vendorName = $row['vendorName'];
    $siteAllocated = $row['siteAllocated'];
    $assignEngineer = $row['assignEngineer'];
    $feasibiltyDone = $row['feasibiltyDone'];

    $data[] = array(
        "Vendor" => $vendorName,
        "siteAllocated" => $siteAllocated,
        "assignEngineer" => $assignEngineer,
        "feasibiltyDone" => $feasibiltyDone,
        "materialRequest" => $materialRequest,
        "materialSend" => $materialSend,
        "project" => 0
    );
}
?>




                        <div class="col-xl-8 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Visitors</h5>
                                    

                                </div>
                                <div class="card-block">
                                    <div id="chartdiv" style="height: 300px; overflow: hidden; text-align: left;">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-12">
                            <div class="card">
                                <div class="card-block bg-c-green">
                                    <div id="proj-earning" style="height: 230px; overflow: hidden; text-align: left;">
                                        <div class="amcharts-main-div" style="position: relative;">
                                            <div class="amcharts-chart-div" style="overflow: hidden; position: relative; text-align: left; width: 617px; height: 230px; padding: 0px; touch-action: auto;">
                                                <svg version="1.1" style="position: absolute; width: 617px; height: 230px; top: 0.361145px; left: -0.215271px;">
                                                    <desc>JavaScript chart by amCharts 3.21.5</desc>
                                                    <g>
                                                        <path cs="100,100" d="M0.5,0.5 L616.5,0.5 L616.5,229.5 L0.5,229.5 Z" fill="#FFFFFF" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0"></path>
                                                        <path
                                                            cs="100,100"
                                                            d="M0.5,0.5 L555.5,0.5 L555.5,179.5 L0.5,179.5 L0.5,0.5 Z"
                                                            fill="#FFFFFF"
                                                            stroke="#000000"
                                                            fill-opacity="0"
                                                            stroke-width="1"
                                                            stroke-opacity="0"
                                                            transform="translate(41,20)"
                                                        ></path>
                                                    </g>
                                                    <g transform="translate(41,20)" clip-path="url(#AmChartsEl-13)"><g visibility="hidden"></g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g>
                                                        <g transform="translate(41,20)">
                                                            <g>
                                                                <g transform="translate(28,179)" aria-label=" UI 10">
                                                                    <path cs="100,100" d="M0.5,0.5 L0.5,-59.5 L56.5,-59.5 L56.5,0.5 L0.5,0.5 Z" fill="#fff" stroke="#fff" fill-opacity="1" stroke-width="1" stroke-opacity="1"></path>
                                                                </g>
                                                                <g transform="translate(139,179)" aria-label=" UX 15">
                                                                    <path cs="100,100" d="M0.5,0.5 L0.5,-133.5 L56.5,-133.5 L56.5,0.5 L0.5,0.5 Z" fill="#fff" stroke="#fff" fill-opacity="1" stroke-width="1" stroke-opacity="1"></path>
                                                                </g>
                                                                <g transform="translate(250,179)" aria-label=" Web 12">
                                                                    <path cs="100,100" d="M0.5,0.5 L0.5,-88.5 L56.5,-88.5 L56.5,0.5 L0.5,0.5 Z" fill="#fff" stroke="#fff" fill-opacity="1" stroke-width="1" stroke-opacity="1"></path>
                                                                </g>
                                                                <g transform="translate(361,179)" aria-label=" App 16">
                                                                    <path cs="100,100" d="M0.5,0.5 L0.5,-148.5 L56.5,-148.5 L56.5,0.5 L0.5,0.5 Z" fill="#fff" stroke="#fff" fill-opacity="1" stroke-width="1" stroke-opacity="1"></path>
                                                                </g>
                                                                <g transform="translate(472,179)" aria-label=" SEO 8">
                                                                    <path cs="100,100" d="M0.5,0.5 L0.5,-29.5 L56.5,-29.5 L56.5,0.5 L0.5,0.5 Z" fill="#fff" stroke="#fff" fill-opacity="1" stroke-width="1" stroke-opacity="1"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g></g>
                                                    <g>
                                                        <g><path cs="100,100" d="M0.5,0.5 L555.5,0.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="#000000" transform="translate(41,199)"></path></g>
                                                        <g><path cs="100,100" d="M0.5,0.5 L0.5,179.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="transparent" transform="translate(41,20)" visibility="visible"></path></g>
                                                    </g>
                                                    <g>
                                                        <g transform="translate(41,20)" clip-path="url(#AmChartsEl-14)" style="pointer-events: none;">
                                                            <path cs="100,100" d="M0.5,0.5 L0.5,0.5 L0.5,179.5" fill="none" stroke-width="1" stroke-opacity="0" stroke="#000000" visibility="hidden"></path>
                                                            <path cs="100,100" d="M0.5,0.5 L555.5,0.5 L555.5,0.5" fill="none" stroke-width="1" stroke="#000000" visibility="hidden"></path>
                                                        </g>
                                                        <clipPath id="AmChartsEl-14"><rect x="0" y="0" width="555" height="179" rx="0" ry="0" stroke-width="0"></rect></clipPath>
                                                    </g>
                                                    <g></g>
                                                    <g><g></g></g>
                                                    <g>
                                                        <g transform="translate(41,20)" visibility="visible">
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="12px" opacity="1" text-anchor="middle" transform="translate(56.5,192)"><tspan y="6" x="0">UI</tspan></text>
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="12px" opacity="1" text-anchor="middle" transform="translate(167.5,192)"><tspan y="6" x="0">UX</tspan></text>
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="12px" opacity="1" text-anchor="middle" transform="translate(278.5,192)"><tspan y="6" x="0">Web</tspan></text>
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="12px" opacity="1" text-anchor="middle" transform="translate(389.5,192)"><tspan y="6" x="0">App</tspan></text>
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="12px" opacity="1" text-anchor="middle" transform="translate(500.5,192)"><tspan y="6" x="0">SEO</tspan></text>
                                                        </g>
                                                        <g transform="translate(41,20)" visibility="visible">
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="11px" opacity="1" text-anchor="end" transform="translate(-12,177.8333330154419)"><tspan y="6" x="0">6</tspan></text>
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="11px" opacity="1" text-anchor="end" transform="translate(-12,147.8333330154419)"><tspan y="6" x="0">8</tspan></text>
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="11px" opacity="1" text-anchor="end" transform="translate(-12,117.8333330154419)"><tspan y="6" x="0">10</tspan></text>
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="11px" opacity="1" text-anchor="end" transform="translate(-12,88.8333330154419)"><tspan y="6" x="0">12</tspan></text>
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="11px" opacity="1" text-anchor="end" transform="translate(-12,58.833333015441895)"><tspan y="6" x="0">14</tspan></text>
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="11px" opacity="1" text-anchor="end" transform="translate(-12,28.833333015441895)"><tspan y="6" x="0">16</tspan></text>
                                                            <text y="6" fill="#fff" font-family="Verdana" font-size="11px" opacity="1" text-anchor="end" transform="translate(-12,-1.1666669845581055)"><tspan y="6" x="0">18</tspan></text>
                                                        </g>
                                                    </g>
                                                    <g transform="translate(41,20)"></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g>
                                                        <g transform="translate(41,20)"></g>
                                                        <g transform="translate(41,20)" visibility="visible">
                                                            <g>
                                                                <path cs="100,100" d="M0.5,179.5 L6.5,179.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="transparent" transform="translate(-6,0)"></path>
                                                                <path cs="100,100" d="M0.5,179.5 L0.5,179.5 L555.5,179.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="#fff"></path>
                                                            </g>
                                                            <g>
                                                                <path cs="100,100" d="M0.5,149.5 L6.5,149.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="transparent" transform="translate(-6,0)"></path>
                                                                <path cs="100,100" d="M0.5,149.5 L0.5,149.5 L555.5,149.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="#fff"></path>
                                                            </g>
                                                            <g>
                                                                <path cs="100,100" d="M0.5,119.5 L6.5,119.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="transparent" transform="translate(-6,0)"></path>
                                                                <path cs="100,100" d="M0.5,119.5 L0.5,119.5 L555.5,119.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="#fff"></path>
                                                            </g>
                                                            <g>
                                                                <path cs="100,100" d="M0.5,90.5 L6.5,90.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="transparent" transform="translate(-6,0)"></path>
                                                                <path cs="100,100" d="M0.5,90.5 L0.5,90.5 L555.5,90.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="#fff"></path>
                                                            </g>
                                                            <g>
                                                                <path cs="100,100" d="M0.5,60.5 L6.5,60.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="transparent" transform="translate(-6,0)"></path>
                                                                <path cs="100,100" d="M0.5,60.5 L0.5,60.5 L555.5,60.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="#fff"></path>
                                                            </g>
                                                            <g>
                                                                <path cs="100,100" d="M0.5,30.5 L6.5,30.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="transparent" transform="translate(-6,0)"></path>
                                                                <path cs="100,100" d="M0.5,30.5 L0.5,30.5 L555.5,30.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="#fff"></path>
                                                            </g>
                                                            <g>
                                                                <path cs="100,100" d="M0.5,0.5 L6.5,0.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="transparent" transform="translate(-6,0)"></path>
                                                                <path cs="100,100" d="M0.5,0.5 L0.5,0.5 L555.5,0.5" fill="none" stroke-width="1" stroke-opacity="0.3" stroke="#fff"></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g><g transform="translate(41,20)"></g></g>
                                                    <g></g>
                                                    <clipPath id="AmChartsEl-13"><rect x="-1" y="-1" width="557" height="181" rx="0" ry="0" stroke-width="0"></rect></clipPath>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <h6 class="text-muted m-b-30 m-t-15">Total completed project and earning</h6>
                                    <div class="row text-center">
                                        <div class="col-6 b-r-default">
                                            <h6 class="text-muted m-b-10">Completed Projects</h6>
                                            <h4 class="m-b-0 f-w-600">175</h4>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="text-muted m-b-10">This Sample Data</h6>
                                            <h4 class="m-b-0 f-w-600">76.6M</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- Chart code -->
<script>
am5.ready(function() {

  // Create root element
  var root = am5.Root.new("chartdiv");

  // Set themes
  root.setThemes([
    am5themes_Animated.new(root)
  ]);

  // Create chart
  var chart = root.container.children.push(am5xy.XYChart.new(root, {
    panX: false,
    panY: false,
    wheelX: "panX",
    wheelY: "zoomX",
    layout: root.verticalLayout
  }));

  // Add legend
  var legend = chart.children.push(
    am5.Legend.new(root, {
      centerX: am5.p50,
      x: am5.p50
    })
  );

  var data = <?php echo json_encode($data); ?>;

  // Create axes
  var xRenderer = am5xy.AxisRendererX.new(root, {
    cellStartLocation: 0.1,
    cellEndLocation: 0.9
  });

  var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
    categoryField: "Vendor",
    renderer: xRenderer,
    tooltip: am5.Tooltip.new(root, {})
  }));

  xRenderer.grid.template.setAll({
    location: 1
  });

  xAxis.data.setAll(data);

  var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
    renderer: am5xy.AxisRendererY.new(root, {
      strokeOpacity: 0.9
    })
  }));

  // Add series
  function makeSeries(name, fieldName) {
    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
      name: name,
      xAxis: xAxis,
      yAxis: yAxis,
      valueYField: fieldName,
      categoryXField: "Vendor"
    }));

    series.columns.template.setAll({
      tooltipText: "{name}, {categoryX}:{valueY}",
      width: am5.percent(90),
      tooltipY: 0,
      strokeOpacity: 0
    });

    series.data.setAll(data.map(function(item) {
      var value = parseFloat(item[fieldName]);
      if (isNaN(value) || value === 0) {
        value = 0.1; // Set a small non-zero value
      }
      item[fieldName] = value;
      return item;
    }));

    series.appear();

    series.bullets.push(function() {
      return am5.Bullet.new(root, {
        locationY: 0,
        sprite: am5.Label.new(root, {
          text: "{valueY}",
          fill: root.interfaceColors.get("alternativeText"),
          centerY: 0,
          centerX: am5.p50,
          populateText: true
        })
      });
    });

    legend.data.push(series);
  }

  makeSeries("Site Allocated", "siteAllocated");
  makeSeries("Engineer Assign", "assignEngineer");
  makeSeries("Feasibility Done", "feasibiltyDone");
  makeSeries("Material Request", "materialRequest");
  makeSeries("Material Send", "materialSend");
  makeSeries("Project Installation", "project");

  chart.appear(1000, 100);

});
</script>
