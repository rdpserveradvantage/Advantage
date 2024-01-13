<? include('../header.php'); ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<div class="row">

    <?php
    $i = 1;
    $sql = mysqli_query($con, "select * from lhositesdelegation where isPending=1");
    $numRows = mysqli_num_rows($sql);
    ?>

    <?php if ($numRows > 0): ?>

        
        <form id="submitForm">
                    <button type="submit">Submit</button>
                </form>


        <table id="example" class="table dataTable js-exportable no-footer" style="width:100%">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th><input type="checkbox" id="check_all">Check All</th>
                    <th>Atmid</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=1; 
                while ($sql_result = mysqli_fetch_assoc($sql)) {
                    $id = $sql_result['id'];
                    $atmid = $sql_result['atmid'];

                    ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td>
                            <input type="checkbox" class="single_site_delegate" value="<?= $id; ?>" />
                        </td>
                        <td><?= $atmid ; ?></td>
                        <td></td>
                    </tr>
                <? $i++ ; } ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No data available</p>
    <?php endif; ?>

</div>


<script>

    
$("#submitForm").submit(function (e) {
        e.preventDefault();
        var checkedIds = [];
        $(".single_site_delegate:checked").each(function () {
            checkedIds.push($(this).val());
        });
        var form = $('<form action="accept_sites.php" method="post"></form>');
        for (var i = 0; i < checkedIds.length; i++) {
            form.append('<input type="hidden" name="checkedIds[]" value="' + checkedIds[i] + '" />');
        }
        $('body').append(form);
        form.submit();
    });




     $("#check_all").change(function () {
        $(".single_site_delegate").prop('checked', $(this).prop("checked"));
    });
</script>
<? include('../footer.php'); ?>


<script src="../datatable/jquery.dataTables.js">
</script>
<script src="../datatable/dataTables.bootstrap.js">
</script>
<script src="../datatable/dataTables.buttons.min.js">
</script>
<script src="../datatable/buttons.flash.min.js">
</script>
<script src="../datatable/jszip.min.js">
</script>

<script src="../datatable/pdfmake.min.js">
</script>
<script src="../datatable/vfs_fonts.js">
</script>
<script src="../datatable/buttons.html5.min.js">
</script>
<script src="../datatable/buttons.print.min.js">
</script>
<script src="../datatable/jquery-datatable.js">
</script>