<?php
	include 'header.php';
	include 'menu.php';
	$classKategori = new Kategori();
	if (isset($_POST['tambah_kategoriutama'])) {
        $namekategoriutama = mysql_escape_string($_POST['namekategoriutama']);
        $deskripsi = mysql_escape_string($_POST['deskripsi']);
        $classKategori->CreateKategoriUtama($namekategoriutama,$deskripsi); 
	}  

	if (isset($_POST['tambah_subkategori'])) {
		$idkategoriutama = mysql_escape_string($_POST['idkategoriutama']);
		$namesubkategori = mysql_escape_string($_POST['namesubkategori']);
        $deskripsi = mysql_escape_string($_POST['deskripsi']);
        $classKategori->CreateSubKategori($idkategoriutama,$namesubkategori,$deskripsi); 
	}

	if (isset($_POST['edit_kategoriutama'])) {
		$namekategori = mysql_escape_string($_POST['namekategori']);
        $deskripsi = mysql_escape_string($_POST['deskripsi']);
        $id = mysql_escape_string($_POST['idkategori']);
        $classKategori->EditKategoriUtama($id,$namekategori,$deskripsi); 
	}
	if (isset($_POST['edit_subkategoriutama'])) {
		$namesubkategori = mysql_escape_string($_POST['namesubkategori']);
        $subdeskripsi = mysql_escape_string($_POST['subdeskripsi']);
        $idsubkategori = mysql_escape_string($_POST['idsubkategori']);
        $classKategori->EditSubKategori($idsubkategori,$namesubkategori,$subdeskripsi); 
	}

	$getkategoriutama = $classKategori->GetKategoriUtama();
	

?>
	

<?php
	if (isset($_GET['action']) && isset($_GET['id'])) {
		$id = base64_decode($_GET['id']);
		$getkategoriutamabyId = $classKategori->getkategoriutamabyId($id);
		$getsubkategori = $classKategori->GetSubKategori($id);

		if ($_GET['action'] == 'view') {
			?>
			<div class="page-content">
				<div class="container-fluid">
					<header class="section-header">
						<div class="row">
							<div class="col-md-9">
								<div class="tbl-cell">
									<h2>Media Ajar - <?php 
									foreach ($getkategoriutamabyId as $datass) { 
										echo $datass['kategori'];
									} ?></h2>
									<div class="subtitle">Gudang Media </div>
								</div>
							</div>
							<div class="col-md-3">
									<div class="tbl-cell">
									<br>
										<button class="btn btn-primary"
											data-toggle="modal"
											data-target=".modal_subkategori">Sub-Kategori</button>
										<div class="modal fade modal_subkategori"
											 tabindex="-1"
											 role="dialog"
											 aria-labelledby="myLargeModalLabel"
											 aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<form class="form-horizontal" method="POST" id="createMemberForm">
														<div class="modal-header">
															<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
																<i class="font-icon-close-2"></i>
															</button>
															<h4 class="modal-title" id="myModalLabel">Tambah Sub-Kategori</h4>
														</div>
														<div class="modal-body">
															<div class="modal-body">
																<div class="form-group">
																	<label for="name" class="col-sm-2 control-label">Kategori Utama</label>
																	<div class="col-sm-10"> 
																		<div class="form-group">
													                        <select name="idkategoriutama" class="bootstrap-select">
												                            	<?php 
																				$no = 1;
																				foreach ($getkategoriutama as $data) {
																			    	?>
																						<option value="<?php echo $data['_id'];?>"><?php echo $data['kategori']; ?></option>
																			    	<?php
																			    	$no++;
																				}
																				?>
													                        </select>
													                    </div>
																	</div>
																</div>
																<br>
																<br>
																<div class="form-group">
																	<label for="name" class="col-sm-2 control-label">Name</label>
																	<div class="col-sm-10"> 
																		<input type="text" class="form-control" id="name" name="namesubkategori" placeholder="Name">
																	</div>
																</div>
																<br>
																<br>
																<div class="form-group">
																	<label for="name" class="col-sm-2 control-label">Deskripsi</label>
																	<div class="col-sm-10"> 
																		<input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi">
																	</div>
																</div>
															</div>			 		
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-rounded btn-primary" name="tambah_subkategori" >Save changes</button>
														</div>
												    </form>
												</div>
											</div>
										</div>
									</div>
								</div>
						</div>
					</header>
					<section class="card">
						<div class="card-block">
							<table id="datatable" class="stripe row-border order-column display table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th width="1%">No</th>
									<th width="29%">Nama Kategori</th>
									<th width="50%">Deskripsi</th>
									<th width="20%">Aksi</th>
								</tr>
								</thead>
								<tbody>
								<?php 
									$no = 1;
									foreach ($getsubkategori as $subdata) {
								    	?>
								    	<tr>
											<td style="text-align:center"><?php echo $no;?></td>
											<td><?php echo $subdata['kategori'];?></td>
											<td><?php echo $subdata['deskripsi'];?></td>
											<td style="text-align:center"> 
												<button class="btn btn-inline btn-warning"
												data-toggle="modal"
												data-target=".modal_editsubkategori<?php echo $no;?>">Edit</button>
												<div class="modal fade modal_editsubkategori<?php echo $no;?>"
													 tabindex="-1"
													 role="dialog"
													 aria-labelledby="myLargeModalLabel"
													 aria-hidden="true">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															<form class="form-horizontal" method="POST" id="createMemberForm">
																<div class="modal-header">
																	<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
																		<i class="font-icon-close-2"></i>
																	</button>
																	<h4 class="modal-title" id="myModalLabel">Edit Kategori</h4>
																</div>
																<div class="modal-body">
																	<div class="modal-body">
																		<div class="form-group" style="width='100%'">
																			<label for="name" class="col-sm-2 control-label">Name</label>
																			<div class="col-sm-10" > 
																				<input type="text" class="form-control" style="width='100%'" id="name" name="namesubkategori" value="<?php echo $subdata['kategori'];?>">
																				<input class="form-control" style="width='100%'" type="hidden" name="idsubkategori" value="<?php echo $subdata['_id'];?>">
																			</div>
																		</div>
																		<br>
																		<br>
																		<div class="form-group">
																			<label for="name" class="col-sm-2 control-label">Deskripsi</label>
																			<div class="col-sm-10"> 
																				<input type="text" class="form-control" id="deskripsi" name="subdeskripsi" value="<?php echo $subdata['deskripsi'];?>">
																			</div>
																		</div>
																	</div>			 		
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close</button>
																	<button type="submit" class="btn btn-rounded btn-primary" name="edit_subkategoriutama" >Save changes</button>
																</div>
														    </form>
														</div>
													</div>
												</div> 
                                				<a class="btn btn-inline btn-danger" href="?action=deletekategori&id=<?=base64_encode($subdata['_id']);?>" >Hapus</a>
											</td>
										</tr>
								    	<?php
								    	$no++;
									}
									?>
								</tbody>
							</table>
						</div>
					</section>
				</div>
			</div>
			<?php
		}elseif ($_GET['action'] == 'deletekategori') {
			$deletesubkategori = $classKategori->DeleteKategori($id);
		} 
	}else{
?>
		<div class="page-content">
			<div class="container-fluid">
				<header class="section-header">
					<div class="row">
						<div class="col-md-9">
							<div class="tbl-cell">
								<h2>Media Ajar</h2>
								<div class="subtitle">Gudang Media </div>
							</div>
						</div>
						<div class="col-md-3">
								<div class="tbl-cell">
								<br>
									<!-- <a class="btn btn-primary" href="#" role="button">Kategori Utama</a> -->
									<button class="btn btn-primary"
										data-toggle="modal"
										data-target=".modal_kategoriutama">Kategori Utama</button>
									<div class="modal fade modal_kategoriutama"
										 tabindex="-1"
										 role="dialog"
										 aria-labelledby="myLargeModalLabel"
										 aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<form class="form-horizontal" method="POST" id="createMemberForm">
													<div class="modal-header">
														<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
															<i class="font-icon-close-2"></i>
														</button>
														<h4 class="modal-title" id="myModalLabel">Tambah Kategori Utama</h4>
													</div>
													<div class="modal-body">
														<div class="modal-body">
															<div class="form-group">
																<label for="name" class="col-sm-2 control-label">Name</label>
																<div class="col-sm-10"> 
																	<input type="text" class="form-control" id="name" name="namekategoriutama" placeholder="Name">
																</div>
															</div>
															<br>
															<br>
															<div class="form-group">
																<label for="name" class="col-sm-2 control-label">Deskripsi</label>
																<div class="col-sm-10"> 
																	<input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi">
																</div>
															</div>
														</div>			 		
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-rounded btn-primary" name="tambah_kategoriutama" >Save changes</button>
													</div>
											    </form>
											</div>
										</div>
									</div>
									<!-- <a class="btn btn-success" href="#" role="button">Sub-Kategori</a> -->
									<button class="btn btn-primary"
										data-toggle="modal"
										data-target=".modal_subkategori">Sub-Kategori</button>
									<div class="modal fade modal_subkategori"
										 tabindex="-1"
										 role="dialog"
										 aria-labelledby="myLargeModalLabel"
										 aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<form class="form-horizontal" method="POST" id="createMemberForm">
													<div class="modal-header">
														<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
															<i class="font-icon-close-2"></i>
														</button>
														<h4 class="modal-title" id="myModalLabel">Tambah Sub-Kategori</h4>
													</div>
													<div class="modal-body">
														<div class="modal-body">
															<div class="form-group">
																<label for="name" class="col-sm-2 control-label">Kategori Utama</label>
																<div class="col-sm-10"> 
																	<div class="form-group">
												                        <select name="idkategoriutama" class="bootstrap-select">
											                            	<?php 
																			$no = 1;
																			foreach ($getkategoriutama as $data) {
																		    	?>
																					<option value="<?php echo $data['_id'];?>"><?php echo $data['kategori']; ?></option>
																		    	<?php
																		    	$no++;
																			}
																			?>
												                        </select>
												                    </div>
																</div>
															</div>
															<br>
															<br>
															<div class="form-group">
																<label for="name" class="col-sm-2 control-label">Name</label>
																<div class="col-sm-10"> 
																	<input type="text" class="form-control" id="name" name="namesubkategori" placeholder="Name">
																</div>
															</div>
															<br>
															<br>
															<div class="form-group">
																<label for="name" class="col-sm-2 control-label">Deskripsi</label>
																<div class="col-sm-10"> 
																	<input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi">
																</div>
															</div>
														</div>			 		
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-rounded btn-primary" name="tambah_subkategori" >Save changes</button>
													</div>
											    </form>
											</div>
										</div>
									</div>
								</div>
							</div>
					</div>
				</header>
				<section class="card">
					<div class="card-block">
						<table id="datatable" class="stripe row-border order-column display table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
							<tr>
								<th width="1%">No</th>
								<th width="29%">Nama Kategori</th>
								<th width="50%">Deskripsi</th>
								<th width="20%">Aksi</th>
							</tr>
							</thead>
							<tbody>
							<?php 
								$no = 1;
								foreach ($getkategoriutama as $data) {
							    	?>
							    	<tr>
										<td style="text-align:center"><?php echo $no;?></td>
										<td><a href="?action=view&id=<?php echo base64_encode($data['_id']);?>" ><?php echo $data['kategori'];?></a></td>
										<td><?php echo $data['deskripsi'];?></td>
										<td style="text-align:center"> 
											<button class="btn btn-inline btn-warning"
												data-toggle="modal"
												data-target=".modal_editkategori<?php echo $no;?>">Edit</button>
											<div class="modal fade modal_editkategori<?php echo $no;?>"
												 tabindex="-1"
												 role="dialog"
												 aria-labelledby="myLargeModalLabel"
												 aria-hidden="true">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<form class="form-horizontal" method="POST" id="createMemberForm">
															<div class="modal-header">
																<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
																	<i class="font-icon-close-2"></i>
																</button>
																<h4 class="modal-title" id="myModalLabel">Edit Kategori</h4>
															</div>
															<div class="modal-body">
																<div class="modal-body">
																	<div class="form-group" style="width='100%'">
																		<label for="name" class="col-sm-2 control-label">Name</label>
																		<div class="col-sm-10" > 
																			<input type="text" class="form-control" style="width='100%'" id="name" name="namekategori" value="<?php echo $data['kategori'];?>">
																			<input class="form-control" style="width='100%'" type="hidden" name="idkategori" value="<?php echo $data['_id'];?>">
																		</div>
																	</div>
																	<br>
																	<br>
																	<div class="form-group">
																		<label for="name" class="col-sm-2 control-label">Deskripsi</label>
																		<div class="col-sm-10"> 
																			<input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?php echo $data['deskripsi'];?>">
																		</div>
																	</div>
																</div>			 		
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-rounded btn-primary" name="edit_kategoriutama" >Save changes</button>
															</div>
													    </form>
													</div>
												</div>
											</div> 
                                			<a class="btn btn-inline btn-danger" href="?action=deletekategori&id=<?=base64_encode($data['_id']);?>" >Hapus</a>
										</td>
									</tr>
							    	<?php
							    	$no++;
								}
								?>
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>
<?php	
	}
?>



<?php
	include 'footer.php';
?>