<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Basic -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <title>Kolom Komentar</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" charset="utf-8"></script>
        
        <script>
            $(document).ready(function(){
                var flag = 0;
                var loading = false;
                var ujung = false;
                console.log($('div.konten-utama').innerHeight());

                if ($('div.konten-utama')[0].scrollHeight < $('div.konten-utama').innerHeight()){
                    $('.loading-bawah').css('display','block');
                    
                    $.ajax({
                        type:"GET",
                        url:"<?=base_url('C_komentar')?>/get_komentar",
                        data: {
                            'offset':0,
                            'limit':5,
                            'login':'<?=$login?>'
                        },
                        success: function(data){
                            console.log(data);
                            if (data != ""){
                                $('.kalo-kosong').css('display','none');
                                $('.isi-konten-utama').append(data);
                                flag += 5;
                                tinymce.init({
                                    selector: 'textarea.editor',
                                    toolbar:false,
                                    height:"350",
                                    menubar:false,
                                    statusbar:false
                                });
                            }
                            $('.loading-bawah').css('display','none');
                        }
                    });
                }

                $('div.konten-utama').on("scroll",function(){
                    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight-85 && !loading && !ujung){
                    console.log("iniflag="+flag);
                    loading = true;
                    $('.loading-bawah').css('display','block');
                    // console.log($(this)[0].scrollHeight);
                    // console.log($(this).scrollTop());
                    // console.log($(this).innerHeight());
                    $.ajax({
                        type:"GET",
                        url:"<?=base_url('C_komentar')?>/get_komentar",
                        data: {
                        'offset':flag,
                        'limit':5,
                        'login':'<?=$login?>'
                        },
                        success: function(data){
                        if (data != ""){
                            $('.kalo-kosong').css('display','none');
                            $('.isi-konten-utama').append(data);
                            flag += 5;
                            tinymce.init({
                            selector: 'textarea.editor',
                            toolbar:false,
                            height:"350",
                            menubar:false,
                            statusbar:false
                            });
                        }else{
                            ujung = true;
                            $('.loading-bawah').css('display','none');
                            $(this).scrollTop($(this)[0].scrollHeight-$(this).innerHeight()-100);
                        }
                        loading=false;
                        }
                    });
                    }
                });
                
                $('#kolom_komentar').click(function(){
                    $('div').scrollTop(0);
                });
            });
        </script>
        <!--To Work with icons-->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <style media="screen">
            .overflow-comment{
              height: 85vh;
              overflow: scroll;
              scroll-behavior:smooth;
            }
            
            .label-container{
              position: -webkit-sticky;
              position: sticky;
            	bottom:48px;
            	right:105px;
            	display:table;
            	visibility: hidden;
            }
            
            .label-text{
            	color:#FFF;
            	background:rgba(51,51,51,0.5);
            	display:table-cell;
            	vertical-align:middle;
            	padding:10px;
            	border-radius:3px;
            }
            
            .label-arrow{
            	display:table-cell;
            	vertical-align:middle;
            	color:#333;
            	opacity:0.5;
            }
            
            .float{
              position: -webkit-sticky;
              position: sticky;
            	width:60px;
            	height:60px;
            	bottom:40px;
            	right:40px;
            	background-color:#00bcd4;
            	color:#FFF;
            	border-radius:50px;
            	text-align:center;
            	box-shadow: 2px 2px 3px #999;
            }
            
            .my-float{
            	font-size:24px;
            	margin-top:18px;
            }
            
            a.float + div.label-container {
              visibility: hidden;
              opacity: 0;
              transition: visibility 0s, opacity 0.5s ease;
            }
            
            a.float:hover + div.label-container{
              visibility: visible;
              opacity: 1;
            }
            
            .gambar-bulat{
              object-fit: cover;
              object-position:top;
              width: 45px;
              height: 45px;
            }
            
            /* Notifikasi */
            .notifikasi{
              white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
              white-space: -pre-wrap;      /* Opera 4-6 */
              white-space: -o-pre-wrap;    /* Opera 7 */
              white-space: pre-wrap;       /* css-3 */
              word-wrap: break-word;       /* Internet Explorer 5.5+ */
              white-space: -webkit-pre-wrap; /* Newer versions of Chrome/Safari*/
              white-space: normal;
              width: 400px;
            }
            
            td{
              vertical-align: top;
            }

            .sbl-half-circle-spin {
                height: 48px;
                width: 48px;
                color: #5a5a5a;
                display: inline-block;
                position: relative;
                border: 1px solid;
                border-radius: 50%;
                animation: animeCircleSpin 4s ease-in-out infinite reverse;
            }
            .sbl-half-circle-spin::after {
                content: '';
                border: 4px solid;
                position: absolute;
                left: 10px;
                top: 4px;
                border-radius: inherit;
            }
            .sbl-half-circle-spin div {
                height: 50%;
                width: 50%;
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                top: 0;
                margin: auto;
                border: 1px solid;
                border-radius: 50%;
                animation: animeCircleSpin 3s ease-in-out infinite;
            }
            .sbl-half-circle-spin div::before {
                height: 0;
                width: 0;
                content: '';
                border-radius: 50%;
                display: block;
            }
            .sbl-half-circle-spin div::before {
                border: 12px solid;
                border-right-color: transparent;
                border-bottom-color: transparent;
                transform: rotate(-45deg);
            }

            @keyframes animeCircleSpin {
                0% {
                    transform: rotate(0);
                }
                50% {
                    transform: rotate(720deg);
                }
                100% {
                    transform: rotate(0);
                }
            }


            .spinner {
                width: 25px;
                height: 25px;

                position: relative;
                /* margin: 10px auto; */
            }

            .double-bounce1, .double-bounce2 {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                background-color: #333;
                opacity: 0.6;
                position: absolute;
                top: 0;
                left: 0;

                -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
                animation: sk-bounce 2.0s infinite ease-in-out;
            }

            .double-bounce2 {
                -webkit-animation-delay: -1.0s;
                animation-delay: -1.0s;
            }

            @-webkit-keyframes sk-bounce {
                0%, 100% { -webkit-transform: scale(0.0) }
                50% { -webkit-transform: scale(1.0) }
            }

            @keyframes sk-bounce {
                0%, 100% {
                    transform: scale(0.0);
                    -webkit-transform: scale(0.0);
                } 50% {
                    transform: scale(1.0);
                    -webkit-transform: scale(1.0);
                }
            }

                /* Spinner bawah */
            .sk-circle {
                /* margin: 100px auto; */
                width: 40px;
                height: 40px;
                position: relative;
            }
            .sk-circle .sk-child {
                width: 100%;
                height: 100%;
                position: absolute;
                left: 0;
                top: 0;
            }
            .sk-circle .sk-child:before {
                content: '';
                display: block;
                margin: 0 auto;
                width: 15%;
                height: 15%;
                background-color: #333;
                border-radius: 100%;
                -webkit-animation: sk-circleBounceDelay 1.2s infinite ease-in-out both;
                        animation: sk-circleBounceDelay 1.2s infinite ease-in-out both;
            }
            .sk-circle .sk-circle2 {
            -webkit-transform: rotate(30deg);
                -ms-transform: rotate(30deg);
                    transform: rotate(30deg); }
            .sk-circle .sk-circle3 {
            -webkit-transform: rotate(60deg);
                -ms-transform: rotate(60deg);
                    transform: rotate(60deg); }
            .sk-circle .sk-circle4 {
            -webkit-transform: rotate(90deg);
                -ms-transform: rotate(90deg);
                    transform: rotate(90deg); }
            .sk-circle .sk-circle5 {
            -webkit-transform: rotate(120deg);
                -ms-transform: rotate(120deg);
                    transform: rotate(120deg); }
            .sk-circle .sk-circle6 {
            -webkit-transform: rotate(150deg);
                -ms-transform: rotate(150deg);
                    transform: rotate(150deg); }
            .sk-circle .sk-circle7 {
            -webkit-transform: rotate(180deg);
                -ms-transform: rotate(180deg);
                    transform: rotate(180deg); }
            .sk-circle .sk-circle8 {
            -webkit-transform: rotate(210deg);
                -ms-transform: rotate(210deg);
                    transform: rotate(210deg); }
            .sk-circle .sk-circle9 {
            -webkit-transform: rotate(240deg);
                -ms-transform: rotate(240deg);
                    transform: rotate(240deg); }
            .sk-circle .sk-circle10 {
            -webkit-transform: rotate(270deg);
                -ms-transform: rotate(270deg);
                    transform: rotate(270deg); }
            .sk-circle .sk-circle11 {
            -webkit-transform: rotate(300deg);
                -ms-transform: rotate(300deg);
                    transform: rotate(300deg); }
            .sk-circle .sk-circle12 {
            -webkit-transform: rotate(330deg);
                -ms-transform: rotate(330deg);
                    transform: rotate(330deg); }
            .sk-circle .sk-circle2:before {
            -webkit-animation-delay: -1.1s;
                    animation-delay: -1.1s; }
            .sk-circle .sk-circle3:before {
            -webkit-animation-delay: -1s;
                    animation-delay: -1s; }
            .sk-circle .sk-circle4:before {
            -webkit-animation-delay: -0.9s;
                    animation-delay: -0.9s; }
            .sk-circle .sk-circle5:before {
            -webkit-animation-delay: -0.8s;
                    animation-delay: -0.8s; }
            .sk-circle .sk-circle6:before {
            -webkit-animation-delay: -0.7s;
                    animation-delay: -0.7s; }
            .sk-circle .sk-circle7:before {
            -webkit-animation-delay: -0.6s;
                    animation-delay: -0.6s; }
            .sk-circle .sk-circle8:before {
            -webkit-animation-delay: -0.5s;
                    animation-delay: -0.5s; }
            .sk-circle .sk-circle9:before {
            -webkit-animation-delay: -0.4s;
                    animation-delay: -0.4s; }
            .sk-circle .sk-circle10:before {
            -webkit-animation-delay: -0.3s;
                    animation-delay: -0.3s; }
            .sk-circle .sk-circle11:before {
            -webkit-animation-delay: -0.2s;
                    animation-delay: -0.2s; }
            .sk-circle .sk-circle12:before {
            -webkit-animation-delay: -0.1s;
                    animation-delay: -0.1s; }

            @-webkit-keyframes sk-circleBounceDelay {
                0%, 80%, 100% {
                    -webkit-transform: scale(0);
                            transform: scale(0);
                } 40% {
                    -webkit-transform: scale(1);
                            transform: scale(1);
                }
            }

            @keyframes sk-circleBounceDelay {
                0%, 80%, 100% {
                    -webkit-transform: scale(0);
                            transform: scale(0);
                } 40% {
                    -webkit-transform: scale(1);
                            transform: scale(1);
                }
            }
        </style>
    </head>
    <body>
        <div class="navbar container">
            <div class="card" style="width:100%;">
                <div class="card-header bg-info">
                    <div class="row justify-content-between">
                        <div class="col-md-auto">
                            <a href="#" id="kolom_komentar"><h1 class="text-white"><i class="fa fa-comments mr-2"></i>Kolom Komentar</h1></a>
                        </div>
                        <!-- Notifikasi -->
                        <div class="col-md-auto">
                            <div class="float-right dropdown">
                                <button class="btn btn-outline-light" id="dropdown-a" data-toggle="dropdown"><i class="fa fa-bell" style="font-size:25px;"></i><span class="badge badge-danger">2</span></button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-a">
                                    <a class="dropdown-item notifikasi" data-toggle="modal" data-target="#modalNotif" href="#">
                                        <table>
                                            <tr>
                                                <td><div class="mt-1"><img src="http://ppdb-man-1-cianjur.com/assets/images/avatar5.png" class="gambar-bulat float-left rounded-circle"/></div></td>
                                                <td><div class="ml-2"><b class="text-primary">Admin PPDB</b> membalas komentar anda
                                                <br><span class="text-secondary" style="font-size:10px;"><?=$yang_lalu?></span></div></td>
                                                <i class="float-right text-white mt-3 fa fa-circle" style="font-size:10px;"></i>
                                            </tr>
                                        </table>
                                    </a>

                                    <a class="dropdown-item notifikasi" data-toggle="modal" data-target="#modalNotif" href="#">
                                        <table>
                                            <tr>
                                                <td><div class="mt-1"><img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="gambar-bulat float-left rounded-circle"/></div></td>
                                                <td><div class="ml-2"><b>Muruyung and friend brother</b> menyukai komentar anda
                                                <br><span class="text-info" style="font-size:10px; font-weight: bold;"><?=$yang_lalu?></span></div></td>
                                                <i class="float-right text-info mt-3 fa fa-circle" style="font-size:10px;"></i>
                                            </tr>
                                        </table>
                                    </a>

                                    <!-- <div class="dropdown-divider"></div> -->
                                    <a class="dropdown-item notifikasi" data-toggle="modal" data-target="#modalNotif" href="#">
                                        <table>
                                            <tr>
                                                <td><div class="mt-1"><img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="gambar-bulat float-left rounded-circle"/></div></td>
                                                <td><div class="ml-2"><b>Muruyung</b> menyukai komentar anda
                                                <br><span class="text-info" style="font-size:10px; font-weight: bold;"><?=$yang_lalu?></span></div></td>
                                                <i class="float-right text-info mt-3 fa fa-circle" style="font-size:10px;"></i>
                                            </tr>
                                        </table>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <!-- End notifikasi -->
                    </div>
                </div>

                <div class="card-body bg-light overflow-comment konten-utama">
                <!-- konten utama -->
                    <div class="isi-konten-utama">
                        <div class="card card-body kalo-kosong" style="margin-top:20px;display:block;">
                            <div class="row" style="margin-bottom:20px;">
                                <div class="col-md-12">
                                    <p>Belum ada komentar apapun</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End modal Body -->
                    <!-- .............. -->
                    <!-- Loading -->
                    <div class="mt-4 loading-bawah" style="display:block;" align="center">
                        <table>
                        <tr>
                            <td>
                            <div class="sk-circle">
                                <div class="sk-circle1 sk-child"></div>
                                <div class="sk-circle2 sk-child"></div>
                                <div class="sk-circle3 sk-child"></div>
                                <div class="sk-circle4 sk-child"></div>
                                <div class="sk-circle5 sk-child"></div>
                                <div class="sk-circle6 sk-child"></div>
                                <div class="sk-circle7 sk-child"></div>
                                <div class="sk-circle8 sk-child"></div>
                                <div class="sk-circle9 sk-child"></div>
                                <div class="sk-circle10 sk-child"></div>
                                <div class="sk-circle11 sk-child"></div>
                                <div class="sk-circle12 sk-child"></div>
                            </div>
                            </td>
                            <td>
                            <div class="ml-3" style="font-size:25px;">
                                Memuat...
                            </div>
                            </td>
                        </tr>
                        </table>

                    </div>
                    <!-- end loading -->

                    <a href="#" class="float float-right" data-toggle="modal" data-target="#modalKomentar">
                        <i class="fa fa-plus my-float"></i>
                    </a>
                    <div class="label-container float-right">
                        <div class="label-text">Tambahkan Komentar</div>
                        <i class="fa fa-play label-arrow"></i>
                    </div>
                </div> <!-- End Card Body -->
            </div>
        </div>

        <!-- Modal -->
        <!-- Modal Komentar -->
        <div class="modal fade" data-keyboard="false" data-backdrop="static" id="modalKomentar" tabindex="-1" role="dialog" aria-labelledby="modalKomentarTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"id="modalKomentarTitle"><b>Komentar</b></h3>
                        <button type="button" class="close" id="close_komentar" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="tulis-komentar">Tulis Komentar:</label>
                                <textarea class="editor" id="komentar" placeholder="Tulis Komentar..."></textarea>
                                <label for="foto-video" class="mt-4">Upload Gambar:</label>
                                <input type="file" class="form-control-file" name="gbr_komentar" id="gbr_komentar" accept="image/jpeg, image/png" aria-describedby="fileHelp">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer" id="kirim_komentar">
                        <button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">Batalkan</button>
                        <button type="button" class="btn btn-info float-right" onclick="kirim('','komentar')">Kirim</button>
                    </div>
                    <div class="modal-footer container" id="mengirim_komentar" style="display:none;">
                        <button type="button" class="btn btn-info float-right" disabled>
                            <div class="row justify-content-md-center">
                                <div class="col-md-7">
                                    Mengirimkan
                                </div>
                                <div class="col-md-3">
                                    <div class="spinner" role="status">
                                        <div class="double-bounce1"></div>
                                        <div class="double-bounce2"></div>
                                    </div>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Login -->
        <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modalLoginTitle"><b>Pemberitahuan</b></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Anda harus melakukan login terlebih dahulu.</p>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-outline-danger float-right" data-dismiss="modal" href="#" >Batalkan</a>
                        <a class="btn btn-info float-right" href="<?=base_url('C_login')?>" >Login</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <!-- <script src="https://cdn.tiny.cloud/1/oxj9kcjafza4iir4lhpytzo8csn0qr7asahxtohtitxa37b2/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
        <script src="<?=base_url();?>assets/tinymce/tinymce.min.js" charset="utf-8"></script>
        <script src="<?=base_url();?>assets/tinymce/jquery.tinymce.min.js" charset="utf-8"></script>

        <script type="text/javascript">
            tinymce.init({
                selector: 'textarea.editor',
                toolbar:false,
                height:"350",
                menubar:false,
                statusbar:false
            });

            function kirim(id,jenis){
                var balasan = tinyMCE.get(jenis+id).getContent();
                var gbr_balasan = document.getElementById('gbr_'+jenis+id);
                // console.log(tinyMCE.get(jenis+id).getContent());
                console.log(gbr_balasan.files[0]);
                if (balasan != "" || gbr_balasan.value != ""){
                    // var kirim = document.getElementById('kirim_'+jenis+id).style;
                    // var mengirim = document.getElementById('mengirim_'+jenis+id).style;
                    // var close = document.getElementById('close_'+jenis+id);
                    // kirim.display = "none";
                    // mengirim.display = "block";
                    // gbr_balasan.disabled = true;
                    // balasan.disabled = true;
                    // close.disabled = true;
                    // tinyMCE.get('textarea.editor').getBody().setAttribute('contenteditable', false);
                    var form_data = new FormData();
                    form_data.append("file", gbr_balasan.files[0]);
                    form_data.append("id", id);
                    form_data.append(jenis, balasan);
                
                    $.ajax({
                        type:"POST",
                        url:"<?=base_url('C_komentar')?>/set_"+jenis,
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){
                            $('#kirim_'+jenis+id).css('display','none');
                            $('#mengirim_'+jenis+id).css('display','block');
                            $('#close_'+jenis+id).prop('disabled',true);
                            $('#'+jenis+id).prop('disabled',true);
                            $('#gbr_'+jenis+id).prop('disabled',true);
                        },
                        success: function(data){
                            // alert(data);
                            // console.log(data);
                            location.reload();
                        }
                    });
                }else{
                    alert("Kolom balasan kosong.");
                }
            }

            function suka(id,jenis){
                var tbl_suka = document.getElementById("suka_"+jenis+id);
                var jml_suka = document.getElementById("jml_suka_"+jenis+id).style;
                var angka_suka = parseInt(document.getElementById("angka_suka_"+jenis+id).innerHTML);
                if (angka_suka == 0 || jml_suka.display == "none"){
                    jml_suka.display = "block";
                }
                angka_suka++;
                document.getElementById("angka_suka_"+jenis+id).innerHTML = angka_suka;
    
                tbl_suka.classList.add("btn-danger");
                tbl_suka.classList.add("text-white");
                tbl_suka.setAttribute('onclick', 'tidak_suka('+id+',"'+jenis+'")');
    
                tbl_suka.classList.remove("btn-outline-danger");
                tbl_suka.classList.remove("text-black");
    
                $.ajax({
                    type:"GET",
                    url:"<?=base_url('C_komentar')?>/set_suka",
                    data: {
                    'id':id,
                    'jenis':jenis
                    },
                    success: function(data){
                    // alert('Sukses');
                    }
                });
    
                $.ajax({
                    type:"GET",
                    url:"<?=base_url('C_komentar')?>/set_notif",
                    data: {
                    'id':id,
                    'jenis':jenis,
                    'notif':'suka'
                    },
                    success: function(data){
                    // alert('Sukses');
                    }
                });
            }

            function tidak_suka(id,jenis){
                var tbl_suka = document.getElementById("suka_"+jenis+id);
                var jml_suka = document.getElementById("jml_suka_"+jenis+id).style;
                var angka_suka = parseInt(document.getElementById("angka_suka_"+jenis+id).innerHTML);
                if (angka_suka == 1){
                    jml_suka.display = "none";
                    angka_suka--;
                    document.getElementById("angka_suka_"+jenis+id).innerHTML = angka_suka;
                }else{
                    angka_suka--;
                    document.getElementById("angka_suka_"+jenis+id).innerHTML = angka_suka;
                }
    
                tbl_suka.classList.remove("btn-danger");
                tbl_suka.classList.remove("text-white");
                tbl_suka.setAttribute('onclick', 'suka('+id+',"'+jenis+'")');
    
                tbl_suka.classList.add("btn-outline-danger");
                tbl_suka.classList.add("text-black");
    
                $.ajax({
                    type:"GET",
                    url:"<?=base_url('C_komentar')?>/del_suka",
                    data: {
                    'id':id,
                    'jenis':jenis
                    },
                    success: function(data){
                    // alert('Sukses');
                    }
                });
                $.ajax({
                    type:"GET",
                    url:"<?=base_url('C_komentar')?>/del_notif",
                    data: {
                        'id':id,
                        'jenis':jenis,
                        'notif':'suka'
                    },
                    success: function(data){
                    // alert('Sukses');
                    }
                });
            }
        </script>
    </body>
</html>