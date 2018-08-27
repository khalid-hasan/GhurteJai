					<!-- SIDEBAR-->
					<div class="col-md-3">
						<div class="sidebar-wrap">
							<div class="side search-wrap animate-box">
								<h3 class="sidebar-heading">Find Your Hotel</h3>
								<form method="GET" class="colorlib-form" action="search_hotel.php">
				              	<div class="row">
				                <div class="col-md-12">
				                    <div class="form-field">
				                      <input type="text" id="hotel_search" class="hotel_location tt-query form-control" autocomplete="off" spellcheck="false" placeholder="Search Location" name="hotel_location">
				                    </div>
				                </div>
				                <div class="col-md-12">
				                </div>
				                <div class="col-md-12">
				                </div>
				                <div class="col-md-12">
				                  <input type="submit" name="submit" id="submit" value="Find Hotel" class="btn btn-primary btn-block">
				                </div>
				              </div>
				            </form>

				            <hr>

								<h3 class="sidebar-heading">Find Tours</h3>
								<form method="GET" class="colorlib-form" action="search_tour.php">
				              	<div class="row">
				                <div class="col-md-12">
				                    <div class="form-field">
				                      <input type="text" id="tour_search" class="hotel_location tt-query form-control" autocomplete="off" spellcheck="false" placeholder="Search Location" name="tour_location">
				                    </div>
				                </div>
				                <div class="col-md-12">
				                </div>
				                <div class="col-md-12">
				                </div>
				                <div class="col-md-12">
				                  <input type="submit" name="submit" id="submit" value="Find Tour" class="btn btn-primary btn-block">
				                </div>
				              </div>
				            </form>

							</div>
							<div class="side animate-box">
								<div class="row">
									<div class="col-md-12">
										<h3 class="sidebar-heading">Hotels- Price Range</h3>
										<form method="GET" class="colorlib-form-2" action="search_by_price.php">
						              	<div class="row">
						                <div class="col-md-6">
						                  <div class="form-group">
						                    <label for="guests">Price from:</label>
						                    <div class="form-field">
						                      <i class="icon icon-arrow-down3"></i>
						                      <select name="min_price" id="min-price-min" class="form-control">
						                        <option value="50">50</option>
						                        <option value="100">100</option>
						                        <option value="200">200</option>
						                        <option value="300">300</option>
						                        <option value="400">400</option>
						                        <option value="500">500</option>
						                      </select>
						                    </div>
						                  </div>
						                </div>
						                <div class="col-md-6">
						                  <div class="form-group">
						                    <label for="guests">Price to:</label>
						                    <div class="form-field">
						                      <i class="icon icon-arrow-down3"></i>
						                      <select name="max_price" id="max-price" class="form-control">
						                        <option value="600">600</option>
						                        <option value="1000">1000</option>
						                        <option value="2000">2000</option>
						                        <option value="3000">3000</option>
						                        <option value="4000">4000</option>
						                        <option value="5000">5000</option>
						                      </select>
						                    </div>
						                  </div>
						                </div>
						                <div class="col-md-12">
						                  <input type="submit" name="submit" id="submit" value="Search" class="btn btn-primary btn-block">
						                </div>						                
						              </div>
						            </form>
					            </div>
								</div>
							</div>

							<div class="side animate-box">
								<div class="row">
									<div class="col-md-12">
										<h3 class="sidebar-heading">Categories</h3>
											<div class="list-group">

								                <?php
								                    require 'config.php';

								                    $statement_cat="select * from categories where deletedAt is null order by cat_id asc";
								                    $res_data_cat = mysqli_query($conn, $statement_cat);

								                    if (mysqli_num_rows($res_data_cat) > 0)
								                    {
								                        while($row = mysqli_fetch_assoc($res_data_cat))
								                        {

											  				echo "<a href=\"categories-view.php?cat_id=$row[cat_id]\" class=\"list-group-item list-group-item-action\">$row[title]</a>";

								                    	}	
								                    }
								                    else
								                    {
								                        echo "Nothing found in db";
								                    }
								                    //mysqli_close($conn);
								                ?>	

											</div>

									</div>
								</div>
							</div>
							<div class="side animate-box">
								<div class="row">
									<div class="col-md-12">
										<h3 class="sidebar-heading">Tour Location</h3>
										<form method="GET" class="colorlib-form-2" action="search_tour.php" name="tour_search" id="tour_search">
			                <?php
			                    require 'config.php';

			                    $statement="select * from tours where deletedAt is null order by tour_id asc LIMIT 5";
			                    $res_data = mysqli_query($conn, $statement);

			                    if (mysqli_num_rows($res_data) > 0)
			                    {
			                        while($row = mysqli_fetch_assoc($res_data))
			                        {


									   echo "<div class=\"form-check\">";
									      echo "<input type=\"radio\" class=\"form-check-input\" id=\"exampleCheck1\" name=\"tour_location\" value=\"$row[location]\">";
									      echo "<label class=\"form-check-label\" for=\"exampleCheck1\">";
												echo "<h4 class=\"place\">$row[location]</h4>";
											echo "</label>";
									   echo "</div>";

			                        }
			                        	echo "<div class=\"col-md-12\">";
						                  	echo "<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Search\" class=\"btn btn-primary btn-block\" ";
						                echo "</div>";	
			                    }
			                    else
			                    {
			                        echo "Nothing found in db";
			                    }
			                    mysqli_close($conn);
			                ?>			

			            				</form>							
									</div>
								</div>
							</div>
						</div>
					</div>