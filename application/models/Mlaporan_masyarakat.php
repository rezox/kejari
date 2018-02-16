<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlaporan_masyarakat extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_all($limit = 20, $offset = 0, $type = 'result')
	{
		if($this->input->get('query') != '')
			$this->db->like('nomor', $this->input->get('query'))
					 ->or_like('deskripsi', $this->input->get('query'))
					 ->or_like('asal', $this->input->get('query'));

		if($type == 'result')
		{
			$this->db->select('laporan_masyarakat.ID AS ID_laporan,laporan_masyarakat.nomor,laporan_masyarakat.tanggal_masuk,laporan_masyarakat.asal, laporan_masyarakat.deskripsi, disposisi.*' );
			
			$this->db->from('laporan_masyarakat');

			$this->db->join('disposisi', 'laporan_masyarakat.ID = disposisi.id_laporan_masyarakat', 'LEFT');

			$this->db->limit($limit, $offset);

			$this->db->order_by('ID_laporan', 'desc');

			return $this->db->get()->result();

		} else {

			$this->db->from('laporan_masyarakat');

			$this->db->join('disposisi', 'laporan_masyarakat.ID = disposisi.id_laporan_masyarakat', 'LEFT');

			$this->db->limit($limit, $offset);

			return $this->db->get()->num_rows();
		}
	}

	public function create()
	{
		$data = array(
			'nomor' => $this->input->post('nomor'),
			'tanggal_masuk' => $this->input->post('tanggal_masuk'),
			'asal' => $this->input->post('asal'),
			'deskripsi' => $this->input->post('deskripsi'),
			'user_id' => $this->input->post('user_id'),
			'status_instrksi' => 'belum'
		); 

		$this->db->insert('laporan_masyarakat', $data);

		if($this->db->affected_rows())
		{
			$this->template->alert(
				' Data Laporan Masyarakat berhasil ditambahkan.', 
				array('type' => 'success','icon' => 'check')
			);
		} else {
			$this->template->alert(
				' Gagal menyimpan data.', 
				array('type' => 'warning','icon' => 'times')
			);
		}

	}

	// public function update($param = 0) 
	// {
	// 	$data = array(
	// 		'nomor' => $this->input->post('nomor'),
	// 		'tanggal_masuk' => $this->input->post('tanggal_masuk'),
	// 		'asal' => $this->input->post('asal'),
	// 		'deskripsi' => $this->input->post('deskripsi'),
	// 		'user_id' => $this->input->post('user_id'),
	// 	);

	// 	$this->db->update('laporan_masyarakat', $data );

	// 	if($this->db->affected_rows())
	// 	{
	// 		$this->template->alert(
	// 			' Data Laporan Masyarakat berhasil diubah.', 
	// 			array('type' => 'success','icon' => 'check')
	// 		);
	// 	} else {
	// 		$this->template->alert(
	// 			' Gagal menyimpan data.', 
	// 			array('type' => 'warning','icon' => 'times')
	// 		);
	// 	}
	// }

	// public function instruksi_disposisi($param)
	// {
	// 	$disposisi = array(
	// 		'id_laporan_masyarakat' => $param,
	// 		'instruksi' => $this->input->post('instruksi'),
	// 	);

	// 	$this->db->insert('disposisi', $disposisi);

	// 	$id_disposisi = $this->db->insert_id();

	// 	$terusan_disposisi = array(
	// 		'id_disposisi' => $id_disposisi,
	// 		'group_id' => $this->input->post('group_id'),
	// 		'tanggal_dispsisi_masuk' => date('Y-m-d H:i:s')
	// 	);

	// 	$this->db->insert('terusan_disposisi', $terusan_disposisi);

	// 	if($this->db->affected_rows())
	// 	{
	// 		$this->template->alert(
	// 			' Instruksi dan disposisi telah dikirim.', 
	// 			array('type' => 'success','icon' => 'check')
	// 		);
	// 	} else {
	// 		$this->template->alert(
	// 			' Gagal menyimpan data.', 
	// 			array('type' => 'warning','icon' => 'times')
	// 		);
	// 	}

	// }
	

}

