<? include('header.php'); ?>

         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
 <style>
        /* Image preview with a default size of 300x300 */
        .image-preview {
            max-width: 300px;
            max-height: 300px;
        }
        #modalBody a{
            margin:10px;
            display: inline-block;
        }
     
    </style>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <table class="table table-hover table-styling">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>Sr No</th>
                                                    <th>ATMID</th>
                                                    <th>Engineer Name</th>
                                                    <th> Images </th>
                                                    <th> Actions </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $counter = 1 ; 
                                                $sql = mysqli_query($con,"select * from sealVerification where status=1 order by id desc") ; 
                                                while($sql_result = mysqli_fetch_assoc($sql)){
                                                    $id = $sql_result['id'];
                                                    $siteid = $sql_result['siteid'];
                                                    $atmid = $sql_result['atmid'];
                                                    $created_by = $sql_result['created_by'] ; 
                                                    $engineerName = getUsername($created_by,true);
                                                    $isVerify = $sql_result['isVerify'];
                                                    ?>
                                                    <tr>
                                                        <td><? echo $counter ; ?></td>
                                                        <td class="strong"><?= $atmid; ?></td>
                                                        <td><?= $engineerName; ?></td>
                                                        <td><button class="view-images-btn" data-atmid="<?= $atmid; ?>" data-id="<?= $id; ?>">View Images</button></td>
                                                        <td>
                                                            <a href="sealVerificationStatus.php?id=<? echo $id; ?>&&isVerfy=1&&siteid=<? echo $siteid; ?>&&atmid=<? echo $atmid; ?>">Approve</a> |
                                                            <a href="sealVerificationStatus.php?id=<? echo $id; ?>&&isVerfy=2&&siteid=<? echo $siteid; ?>&&atmid=<? echo $atmid; ?>">Reject</a>
                                                            <?
                                                            if($isVerify==0){
                                                                echo ' | Pending ' ; 
                                                            }elseif($isVerify==1){
                                                                echo ' | Approved ! ' ; 
                                                            }elseif($isVerify==2){
                                                                echo ' | Rejected ! ' ; 
                                                            }
                                                            ?>
                                                            
                                                        </td>

                                                    </tr>
                                                <? $counter++ ;  } ?>
                                            </tbody>
                                        </table>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                
                

<!-- The Bootstrap modal to display images -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Images for ATM ID: <span id="atmIdSpan"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Image previews will be dynamically added here -->
            </div>
        </div>
    </div>
</div>

<!-- Lightbox2 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

<script>
    // JavaScript to handle the button click and populate the modal with images
    const viewImagesBtns = document.querySelectorAll('.view-images-btn');
    const imageModal = document.getElementById('imageModal');
    const atmIdSpan = document.getElementById('atmIdSpan');
    const modalBody = document.getElementById('modalBody');

    viewImagesBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const atmid = this.dataset.atmid;
            atmIdSpan.textContent = atmid;
            modalBody.innerHTML = ''; // Clear previous image previews

            // Make an AJAX request to fetch the images for the given ID
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `get_images.php?id=${id}`, true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success && response.images.length > 0) {
                        // Loop through the images and add them to the modal
                        response.images.forEach(imagePath => {
                            // Open the image in a new tab when clicked
                            const imgLink = document.createElement('a');
                            imgLink.href = imagePath;
                            imgLink.target = '_blank'; // Open in new tab
                            
                            const img = document.createElement('img');
                            img.src = imagePath;
                            img.classList.add('image-preview');
                            img.style.maxWidth = '400px'; // Set maximum width
                            img.style.maxHeight = '400px'; // Set maximum height
                            
                            imgLink.appendChild(img);
                            modalBody.appendChild(imgLink);
                        });
                        // Open the modal
                        $(imageModal).modal('show');
                    } else {
                        modalBody.innerHTML = '<p>No images found for this ATM ID.</p>';
                        // Open the modal
                        $(imageModal).modal('show');
                    }
                }
            };

            xhr.send();
        });
    });
</script>

<? include('footer.php'); ?>