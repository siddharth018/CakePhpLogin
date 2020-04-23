<div class="row top-buffer" style="margin-top:15px;">
  <div class="index large-8 medium-8 large-offset-2 medium-offset-2 columns">
    <form action="?results=" method="get">
    <input id="myInput" class="controls" name="results" type="text" placeholder="Search Box">
    <button type="submit">Show Result</button>
    </form>
    <?php
    if (isset($_GET['results']) && $_GET['results'] != "") {
        $url = "https://www.googleapis.com/customsearch/v1?key=API_KEY&cx=016267591411015987395:f7fzlpbvhmg&q=" . str_replace(' ', '%20', $_GET['results']);
        
        $body = file_get_contents($url);
        $json = json_decode($body);
        echo '';
        if ($json->items) {
    ?>
    <input type="button" id="btnExport" value="Export"/>
    <table id="tblCustomers" cellspacing="0" cellpadding="0">
        <tr>
            <th>Title</th>
            <th>Link</th>
            <th>Snippet</th>
        </tr>
        
        <?php
        foreach ($json->items as $item) {
        ?>
       <tr>
             <td><?php echo $item->title; ?></td> 
             <td><?php echo $item->link; ?></td>
             <td><?php echo $item->snippet; ?></td>
            </tr>
        <?php
        }
    ?>
   </table>
    <?php
    }
}
?>
    
    </div>
    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
        $("body").on("click", "#btnExport", function () {
            html2canvas($('#tblCustomers')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Table.pdf");
                }
            });
        });
    </script>