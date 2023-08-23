<?php $this->view('front/blocks/head.php'); ?>
<?php $this->view('front/blocks/header.php'); ?>

<div class="gallery_section layout_padding">
  <div class="container-fluid">
    <div class="heading_container heading_center">
      <h2>
        Gallery
      </h2>
    </div>
    <div class="row">
      <div class=" col-sm-8 col-md-6 px-0">
        <div class="img-box">
          <img src="images/g1.jpg" alt="">
          <a href="images/g1.jpg" data-toggle="lightbox" data-gallery="gallery">
            <i class="fa fa-picture-o" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      <div class="col-sm-4 col-md-3 px-0">
        <div class="img-box">
          <img src="images/g2.jpg" alt="">
          <a href="images/g2.jpg" data-toggle="lightbox" data-gallery="gallery">
            <i class="fa fa-picture-o" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      <div class="col-sm-6 col-md-3 px-0">
        <div class="img-box">
          <img src="images/g3.jpg" alt="">
          <a href="images/g3.jpg" data-toggle="lightbox" data-gallery="gallery">
            <i class="fa fa-picture-o" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      <div class="col-sm-6 col-md-3 px-0">
        <div class="img-box">
          <img src="images/g4.jpg" alt="">
          <a href="images/g4.jpg" data-toggle="lightbox" data-gallery="gallery">
            <i class="fa fa-picture-o" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      <div class="col-sm-4 col-md-3 px-0">
        <div class="img-box">
          <img src="images/g5.jpg" alt="">
          <a href="images/g5.jpg" data-toggle="lightbox" data-gallery="gallery">
            <i class="fa fa-picture-o" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      <div class="col-sm-8 col-md-6 px-0">
        <div class="img-box">
          <img src="images/g6.jpg" alt="">
          <a href="images/g6.jpg" data-toggle="lightbox" data-gallery="gallery">
            <i class="fa fa-picture-o" aria-hidden="true"></i>
          </a>
        </div>
      </div>
    </div>
    <div class="btn-box">
      <a href="">
        View All
      </a>
    </div>
  </div>
</div>

<!-- end gallery section -->


<!-- info section -->
<section class="info_section innerpage_info_section">
  <div class="container">
    <div class="row info_main_row">
      <div class="col-md-6 col-lg-3">
        <div class="info_insta">
          <h4>
            <a href="index.html" class="navbar-brand m-0 p-0">
              <span>
                Shapel
              </span>
            </a>
          </h4>
          <p class="mb-0">
            Asperiores at, error, delectus aut voluptatem provident cum quam magni necessitatibus molestias eveniet reprehenderit maiores voluptate.
          </p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="info_detail">
          <h4>
            Company
          </h4>
          <p class="mb-0">
            when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to
          </p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <h4>
          Contact Us
        </h4>
        <div class="info_contact">
          <a href="">
            <i class="fa fa-map-marker" aria-hidden="true"></i>
            <span>
              Location
            </span>
          </a>
          <a href="">
            <i class="fa fa-phone" aria-hidden="true"></i>
            <span>
              Call +01 1234567890
            </span>
          </a>
          <a href="">
            <i class="fa fa-envelope"></i>
            <span>
              demo@gmail.com
            </span>
          </a>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <h4>
          Follow Us
        </h4>
        <div class="social_box">
          <a href="">
            <i class="fa fa-facebook" aria-hidden="true"></i>
          </a>
          <a href="">
            <i class="fa fa-twitter" aria-hidden="true"></i>
          </a>
          <a href="">
            <i class="fa fa-linkedin" aria-hidden="true"></i>
          </a>
          <a href="">
            <i class="fa fa-instagram" aria-hidden="true"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php $this->view('front/blocks/footer.php'); ?>