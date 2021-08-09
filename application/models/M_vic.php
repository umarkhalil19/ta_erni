<?php
class M_vic extends CI_Model{
	// general
	function edit_data($where,$table){
		return $this->db->get_where($table,$where);
	} 

	function portal_login($where,$table)
	{
		$db2 = $this->load->database('portal',TRUE);
		return  $db2->get_where($table,$where);
	}

	function get_data($table){
		return $this->db->get($table);
	}

	function insert_data($data,$table){
		$this->db->insert($table,$data);
	}

	function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}

	function delete_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}

	function get_data_order($order,$column,$table){
		$this->db->order_by($column, $order);
		return $this->db->get($table);
	}

	function get_group($table,$group){
		return $this->db->query("SELECT * FROM $table group by $group");
	}

	function get_group_visitor($table,$group,$date){
		return $this->db->query("SELECT * FROM $table WHERE date(time_visit)='$date' group by $group");
	}
	// end general

	// cms
	function get_posts($post_status){
		$this->db->order_by('post_id', 'desc');
		$this->db->where(array('post_status'=> $post_status));
		return $this->db->get('tbl_posts');
	}

	function get_posts_paging($post_status,$sampai,$dari){
		$this->db->order_by('post_id', 'desc');
		$this->db->where(array('post_status'=> $post_status,));
		return $this->db->get('tbl_posts',$sampai,$dari);
	}

	function search($keyword){
		//$this->db->like('post_content',$keyword);
		$this->db->like(array('post_tittle'=> $keyword,'post_content' => $keyword));
		return $query  =   $this->db->get('tbl_posts');
	}

	function get_search($post_status,$search){
		$this->db->order_by('post_id', 'desc');
		$this->db->where(array('post_status'=> $post_status, 'post_tittle'=> $search,'post_content' => $search));
		return $this->db->get('tbl_posts');
	}

	function get_search_paging($search,$sampai,$dari){
		$this->db->order_by('post_id', 'desc');
		$this->db->like(array('post_tittle'=> $search,'post_content' => $search));
		return $this->db->get('tbl_posts',$sampai,$dari);
	}

	function get_kategori_paging($kategori,$sampai,$dari){
		// $this->db->order_by('post_id', 'desc');
		// $this->db->where(array('post_kategori'=> $kategori));
		return $this->db->query("SELECT * FROM tbl_posts,tbl_kategori,tbl_taxonomy WHERE tbl_taxonomy.taxonomy='post_kategori' AND tbl_taxonomy.taxonomy_child=tbl_kategori.kategori_id AND tbl_kategori.kategori_id=$kategori AND tbl_posts.post_id=tbl_taxonomy.taxonomy_parent AND tbl_posts.post_status = 'Publish' ORDER BY tbl_posts.post_id DESC LIMIT $dari,$sampai");
		// return $this->db->get('tbl_posts',$sampai,$dari);
	}

	function get_tag_paging($tag,$sampai,$dari){
		return $this->db->query("SELECT * FROM tbl_posts,tbl_tag,tbl_taxonomy WHERE tbl_taxonomy.taxonomy='post_tag' AND tbl_taxonomy.taxonomy_child=tbl_tag.tag_id AND tbl_tag.tag_id=$tag AND tbl_posts.post_id=tbl_taxonomy.taxonomy_parent AND tbl_posts.post_status = 'Publish' ORDER BY tbl_posts.post_id DESC LIMIT $dari,$sampai");
	}

	function get_author_paging($author,$sampai,$dari){
		return $this->db->query("SELECT * FROM tbl_posts,tbl_kategori,tbl_taxonomy WHERE tbl_taxonomy.taxonomy='post_kategori' AND tbl_taxonomy.taxonomy_child=tbl_kategori.kategori_id AND tbl_posts.post_author='$author' AND tbl_posts.post_id=tbl_taxonomy.taxonomy_parent AND tbl_posts.post_status = 'Publish' ORDER BY tbl_posts.post_id DESC LIMIT $dari,$sampai");
	}

	function get_post_limit($post_status,$limit){
		$this->db->limit($limit);
		$this->db->order_by('post_id', 'desc');
		$this->db->where(array('post_status'=> $post_status));
		return $this->db->get('tbl_posts');
	}

	function get_post_limit2($post_status,$limit,$idkategori){
		return $this->db->query("SELECT * FROM tbl_taxonomy,tbl_kategori,tbl_posts WHERE tbl_taxonomy.taxonomy_child='$idkategori' AND tbl_taxonomy.taxonomy='post_kategori' AND tbl_taxonomy.taxonomy_child=tbl_kategori.kategori_id AND tbl_taxonomy.taxonomy_parent=tbl_posts.post_id AND post_status = '$post_status' ORDER BY post_id DESC LIMIT $limit");
	}

	function get_post_kategori($id_post){
		return $this->db->query("SELECT * FROM tbl_taxonomy,tbl_kategori WHERE tbl_taxonomy.taxonomy_parent='$id_post' AND tbl_taxonomy.taxonomy='post_kategori' AND tbl_taxonomy.taxonomy_child=tbl_kategori.kategori_id ");
	}

	function get_update_baca($id_post){
		return $this->db->query("UPDATE tbl_posts SET post_baca = post_baca + 1 WHERE post_id = '$id_post'");
	}

	function post_in_kategori($id_kategori){
		return $this->db->query("SELECT * FROM tbl_taxonomy,tbl_kategori,tbl_posts WHERE tbl_taxonomy.taxonomy_child='$id_kategori' AND tbl_taxonomy.taxonomy='post_kategori' AND tbl_taxonomy.taxonomy_child=tbl_kategori.kategori_id AND tbl_taxonomy.taxonomy_parent=tbl_posts.post_id");
	}

	function get_post_tag($id_post){
		return $this->db->query("SELECT * FROM tbl_taxonomy,tbl_tag WHERE tbl_taxonomy.taxonomy_parent='$id_post' AND tbl_taxonomy.taxonomy='post_tag' AND tbl_taxonomy.taxonomy_child=tbl_tag.tag_id ");
	}

	function post_in_tag($id_tag){
		return $this->db->query("SELECT * FROM tbl_taxonomy,tbl_tag,tbl_posts WHERE tbl_taxonomy.taxonomy_child='$id_tag' AND tbl_taxonomy.taxonomy='post_tag' AND tbl_taxonomy.taxonomy_child=tbl_tag.tag_id AND tbl_taxonomy.taxonomy_parent=tbl_posts.post_id");
	}

	function post_in_author($id_author){
		return $this->db->query("SELECT * FROM tbl_taxonomy,tbl_kategori,tbl_posts WHERE tbl_posts.post_author='$id_author' AND tbl_taxonomy.taxonomy='post_kategori' AND tbl_taxonomy.taxonomy_child=tbl_kategori.kategori_id AND tbl_taxonomy.taxonomy_parent=tbl_posts.post_id");
	}

	function get_post_detail($id_post){
		return $this->db->query("SELECT * FROM tbl_posts,tbl_pegawai WHERE tbl_posts.post_author=tbl_pegawai.peg_user AND tbl_posts.post_id='$id_post'");
	}

	// function get_update_baca($id_post){
	// 	return $this->db->query("UPDATE tbl_posts SET post_baca = post_baca + 1 WHERE post_id = '$id_post'");
	// }

	function get_update_media($id_media){
		return $this->db->query("UPDATE tbl_media SET media_baca = media_baca + 1 WHERE media_id = '$id_media'");
	}
	// end cms


	// get options
	function get_option($option_name){
		$query = $this->db->query("SELECT option_value FROM tbl_options WHERE option_name='$option_name'")->row();
		return $query->option_value;
	}
	// end get option

	// menu
	function get_menu_mother(){
		//return $this->db->query("SELECT * FROM tbl_menu WHERE menu_mother != '0' AND menu_name='0' AND menu_url='0' AND menu_parent='0' AND menu_sort='0'");
		return $this->db->query("SELECT * FROM tbl_menu WHERE menu_mother != '0' AND menu_name!='0' AND menu_url!='0' AND menu_parent='0' AND menu_sort='0'");
	}

	function get_menu_item($mother){
		return $this->db->query("SELECT * FROM tbl_menu WHERE menu_mother = '$mother' AND menu_name!='0' AND menu_parent='0' ORDER BY menu_sort ASC");
	}

	function get_all_menu_item($mother){
		return $this->db->query("SELECT * FROM tbl_menu WHERE menu_mother = '$mother' AND menu_name!='0' ORDER BY menu_sort ASC");
	}
	// end menu


	// visitor
	function get_pageview($date){
		return $this->db->query("SELECT * FROM tbl_visitor WHERE date(time_visit)='$date'");
	}

	function get_visitor($date){
		return $this->db->query("SELECT * FROM tbl_visitor WHERE date(time_visit)='$date' group by user_ip");
	}

	function get_ftvisitor($date){
		return $this->db->query("SELECT * FROM tbl_visitor WHERE date(time_visit)='$date' AND user_ip not in(select user_ip from tbl_visitor)");
	}

	function page_view($date){
		return $this->db->query("select count(page) as page_view, page from tbl_visitor WHERE date(time_visit)='$date' group by page ORDER BY page_view desc");
	}

	function get_referrer($date){
		return $this->db->query("select distinct user_referrer from tbl_visitor WHERE date(time_visit)='$date' AND user_referrer!=''");
	}

	function panggil_db(){
		//$db = mysqli_connect("localhost", "kerj_pengguna", "katasandi");
		$db = mysqli_connect("localhost", "root", "");
		mysqli_select_db($db, "db_unimal_simail");
		return $db;
	}

}
?>