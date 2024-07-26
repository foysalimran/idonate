<div class="donorinfo donor-view-wrapper admin_popup">
	<div class="donor-view-inner">
		<h3><?php esc_html_e('Donor Information', 'idonate'); ?></h3>
		<hr>
		<!-- Personal Info-->
		<# if( data.profilepic ){ #>
			<div class="donor-img">
				<img src="{{data.profilepic}}">
			</div>
			<# } #>
			<# if( data.full_name ){ #>
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('Full Name: ', 'idonate'); ?></strong>{{data.full_name}}</p>
					</div>
				</div>
				<# } #>
				<# if( data.gender ){ #>
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('Gender: ', 'idonate'); ?></strong>{{data.gender}}</p>
					</div>
				</div>
				<# } #>
				<# if( data.date_birth ){ #>
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('Date Of Birth: ', 'idonate'); ?></strong>{{data.date_birth}}</p>
					</div>
				</div>
				<# } #>
				<# if( data.country ){ #>
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('Country: ', 'idonate'); ?></strong>{{data.country}}</p>
					</div>
				</div>
				<# } #>
				<# if( data.state ){ #>
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('State: ', 'idonate'); ?></strong>{{data.state}}</p>
					</div>
				</div>
				<# } #>
				<# if( data.city ){ #>
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('City: ', 'idonate'); ?></strong>{{data.city}}</p>
					</div>
				</div>
				<# } #>
				<# if( data.address ){ #>
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('Address: ', 'idonate'); ?></strong>{{data.address}}</p>
					</div>
				</div>
				<# } #>
				<!-- Blood Info-->
				<# if( data.bloodgroup ){ #>
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('Blood Group: ', 'idonate'); ?></strong>{{data.bloodgroup}}</p>
					</div>
				</div>
				<# } #>
				<# if( data.availability ){ #>
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('Availability: ', 'idonate'); ?></strong>{{data.availability}}</p>
					</div>
				</div>
				<# } #>
				<# if( data.mobile ){ #>
				<!-- Contct Info-->
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('Mobile Number: ', 'idonate'); ?></strong>{{data.mobile}}</p>
					</div>
				</div>
				<# } #>
				<# if( data.landline ){ #>
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('Land Line Number: ', 'idonate'); ?></strong>{{data.landline}}</p>
					</div>
				</div>
				<# } #>
				<# if( data.email ){ #>
				<!-- Account Info-->
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('E-Mail ID: ', 'idonate'); ?></strong>{{data.email}}</p>
					</div>
				</div>
				<# } #>
				<# if( data.user_name ){ #>
				<div class="idonate_row idonate_col">
					<div class="idonate_col_item">
						<p><strong><?php esc_html_e('User Name: ', 'idonate'); ?></strong>{{data.user_name}}</p>
					</div>
				</div>
				<# } #>
	</div>
</div>