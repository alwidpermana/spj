<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4><?php echo $page;?></h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?=base_url()?>Dashboard" class="text-danger">Home</a></li>
          <li class="breadcrumb-item active">
              <?php 
              $a= strtoupper($this->uri->segment('1'));
              echo str_replace("_", " ", $a);
              ?>
          </li>
          <?php 
              if ($this->uri->segment('2')!="") {
                echo '<li class="breadcrumb-item active">';
            
                $b= strtoupper($this->uri->segment('2'));
                echo str_replace("_", " ", $b);
                echo '</li>';
              }
              
            ?>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>