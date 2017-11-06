<div class="e2g">
	<?php
		if (IN_MANAGER_MODE != 'true')
			die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODx Content Manager instead of accessing this file directly.");

		$icon_ok = '<i class="icon-custom icon-no-border icon-color-green fa fa-check icon-vs"></i>';
		$icon_bad = '<i class="icon-custom icon-no-border icon-color-red fa fa-times icon-vs"></i>';

		echo $this->plugin('OnE2GDashboardPrerender');
	?>
	<div class="dashboardContent">
		<table style="width: 100%;">
			<tr>
				<td class="tdLeft">
					<div class="curveBox">
						<div class="h2title"><?php echo $this->lng['info_gallery']; ?></div>
						<table>
							<tr>
								<td class="dash-title"><?php echo $this->lng['folders']; ?></td>
								<td class="dash-title-col">:</td>
								<td>
									<?php
										echo $this->modx->db->getValue($this->modx->db->query('SELECT COUNT(cat_id) FROM ' . $this->modx->db->config['table_prefix'] . 'easy2_dirs '));
									?>
								</td>
							</tr>
							
							<tr>
								<td class="dash-title"><?php echo $this->lng['folders_hidden']; ?></td>
								<td class="dash-title-col">:</td>
								<td>
									<?php
										echo $this->modx->db->getValue($this->modx->db->query('SELECT COUNT(cat_id) FROM ' . $this->modx->db->config['table_prefix'] . 'easy2_dirs WHERE cat_visible=\'0\''));
									?>
								</td>
							</tr>
						
							<tr>
								<td class="dash-title"><?php echo $this->lng['files']; ?></td>
								<td class="dash-title-col">:</td>
								<td>
									<?php
										echo $this->modx->db->getValue($this->modx->db->query('SELECT COUNT(id) FROM ' . $this->modx->db->config['table_prefix'] . 'easy2_files '));
									?>
									(
									<?php
										$fileSizeArray = $this->modx->db->makeArray($this->modx->db->query('SELECT size FROM ' . $this->modx->db->config['table_prefix'] . 'easy2_files '));
										$capacity = (int) 0;
										foreach ($fileSizeArray as $k => $v) {
											$capacity += (int) $v['size'];
										}
										if ($capacity < 1024)
										echo $capacity . ' bytes';
										elseif ($capacity < 1048576)
										echo round($capacity / 1024, 2) . ' ' . $this->lng['kilobytes'];
										else
										echo round($capacity / 1048576, 2) . ' ' . $this->lng['megabytes'];
									?>
									)
								</td>
							</tr>
						
							<tr>
								<td class="dash-title"><?php echo $this->lng['files_hidden']; ?></td>
								<td class="dash-title-col">:</td>
								<td>
									<?php
										echo $this->modx->db->getValue($this->modx->db->query('SELECT COUNT(id) FROM ' . $this->modx->db->config['table_prefix'] . 'easy2_files WHERE status=\'0\''));
									?>
									(
									<?php
										$fileSizeArray = $this->modx->db->makeArray($this->modx->db->query('SELECT size FROM ' . $this->modx->db->config['table_prefix'] . 'easy2_files WHERE status=\'0\''));
										$capacity = (int) 0;
										foreach ($fileSizeArray as $k => $v) {
											$capacity += (int) $v['size'];
										}
										if ($capacity < 1024)
										echo $capacity . " bytes";
										elseif ($capacity < 1048576)
										echo round($capacity / 1024, 2) . ' ' . $this->lng['kilobytes'];
										else
										echo round($capacity / 1048576, 2) . ' ' . $this->lng['megabytes'];
									?>
									)
								</td>
							</tr>
						</table>
					</div>
					
					<!--div class="curveBox">
					<div class="h2title">Last uploads</div>
					</div-->
					
					<div class="curveBox">
						<div class="h2title"><?php echo $this->lng['comments']; ?></div>
						<table>
							<tr>
								<td class="dash-title"><?php echo $this->lng['comments']; ?></td>
								<td class="dash-title-col">:</td>
								<td>
									<?php
										echo $this->modx->db->getValue($this->modx->db->query('SELECT COUNT(id) FROM ' . $this->modx->db->config['table_prefix'] . 'easy2_comments '));
									?>
								</td>
							</tr>
							<tr>
								<td class="dash-title"><?php echo $this->lng['comments_unapproved']; ?></td>
								<td class="dash-title-col">:</td>
								<td>
									<?php
										echo $this->modx->db->getValue($this->modx->db->query(
										'SELECT COUNT(id) FROM ' . $this->modx->db->config['table_prefix'] . 'easy2_comments '
										. 'WHERE `approved`=\'0\''
										));
									?>
								</td>
							</tr>
						</table>
					</div>
				
					<!--div class="curveBox">
						<div class="h2title">Statistics</div>
						<table>
							<tr>
								<td>Top 10 hits</td>
								<td>:</td>
								<td>link</td>
							</tr>
							<tr>
								<td>Top 10 rating</td>
								<td>:</td>
								<td>link</td>
							</tr>
							<tr>
								<td>10 Most Commented</td>
								<td>:</td>
								<td>link</td>
							</tr>
						</table>
					</div-->
				</td>
				
				<td class="tdRight">
					<!--div class="curveBox">
						<div class="h2title">News</div>
					</div-->
					<div class="curveBox">
						<div class="h2title"><?php echo $this->lng['info_system']; ?></div>
						<table>
							<tr>
								<td class="dash-title"><?php echo $this->lng['server']; ?></td>
								<td class="dash-title-col">:</td>
								<td><?php echo getenv('SERVER_SOFTWARE'); ?></td>
							</tr>
							<tr>
								<td class="dash-title"><?php echo $this->lng['magic_quote']; ?></td>
								<td class="dash-title-col">:</td>
								<td>
									<?php
									// PHP magic_quotes_gpc()
									if (get_magic_quotes_gpc()) {
									echo $this->lng['on'] . $icon_bad . ' ' . $this->lng['magic_quote_disabling'];
									} else {
										echo $this->lng['off'] . $icon_ok;
									}
									?>
								</td>
							</tr>
							
							<tr>
								<td class="dash-title"><?php echo $this->lng['multibyte_string']; ?></td>
								<td class="dash-title-col">:</td>
								<td>
									<?php
									if (function_exists('mb_get_info') && is_array(mb_get_info())) {
									echo $this->lng['enabled'] . ' ' . $icon_ok;
									} else {
										echo $this->lng['disabled'] . ' ' . $icon_bad;
									}
									?>
								</td>
							</tr>
							
							<tr>
								<td class="dash-title">set_time_limit</td>
								<td class="dash-title-col">:</td>
								<td >
									<?php
									if (function_exists('set_time_limit')) {
									echo $this->lng['enabled'] . ' ' . $icon_ok;
									} else {
										echo $this->lng['disabled'] . ' ' . $icon_bad;
									}
									?>
								</td>
							</tr>
							
							<tr>
								<td class="dash-title">ZipArchive</td>
								<td class="dash-title-col">:</td>
								<td>
									<?php
									if (class_exists('ZipArchive')) {
									echo $this->lng['enabled'] . ' ' . $icon_ok;
									} else {
										echo $this->lng['disabled'] . ' ' . $icon_bad;
									}
									?>
								</td>
							</tr>
							
							<tr>
								<td class="dash-title"><?php echo $this->lng['upload_max']; ?></td>
								<td class="dash-title-col">:</td>
								<td><?php echo ini_get('upload_max_filesize'); ?></td>
							</tr>
							
							<tr>
								<td class="dash-title">MySQL</td>
								<td class="dash-title-col">:</td>
								<td><?php echo $this->modx->db->getVersion(); ?></td>
							</tr>
							
							<tr>
								<td class="dash-title"><?php echo $this->lng['database']; ?></td>
								<td class="dash-title-col">:</td>
								<td><?php echo str_replace('`', '', $this->modx->db->config['dbase']); ?></td>
							</tr>
							
							<tr>
								<td class="dash-title"><?php echo $this->lng['gallery_folder']; ?></td>
								<td class="dash-title-col">:</td>
								<td><?php echo $this->e2gModCfg['gdir']; ?></td>
							</tr>
						</table>
					</div>
					
					<div class="curveBox">
						<div class="h2title"><?php echo $this->lng['utilities']; ?></div>
						<table width="100%">
							<tr>
								<td width="50%">
									<div class="clearcacheButton">
										<a href="<?php echo $this->e2gModCfg['index']; ?>&amp;act=clean_cache">
											<span><?php echo $this->lng['clean_cache']; ?> <i class="fa fa-trash"></i></span>
										</a>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	<div class="clear">&nbsp;</div>
	</div>
<?php echo $this->plugin('OnE2GDashboardRender'); ?>
</div>