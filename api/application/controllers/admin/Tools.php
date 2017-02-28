<?php

/**
 * Tools short summary.
 *
 * Tools description.
 *
 * @version 1.0
 * @author Administrator
 */
class Tools extends CI_Controller
{
    //��ק����
    public function sort()
    {
        $t=$_GET['t'];
        $i=$_GET['i'];

        if(isset($i))
        {
            $i=explode(',',$i);

            $this->db->trans_start();

            for($k=0; $k<count($i); $k++)
            {
                $this->db->query('UPDATE `'.$t.'` SET sort_order='.$k.' WHERE id='.$i[$k]);
            }

            $this->db->trans_complete();

        }
    }

    //��鵥���Ƿ����
    public function check()
    {
        $w=$_GET['w'];
        $id=$_GET['id'];

        $sql="SELECT id FROM word WHERE en=?";

        if($id)
        {
            $sql.=" AND id<>".$id;
        }

        echo $this->db->query($sql,array($w))->num_rows();
    }

    //��������
    public function search()
    {
        $w=$_GET['term'];

        if($w&&trim($w))
        {
            $w=trim($w);

            if($w)
            {
                $query=$this->db->query("SELECT id, en as value,zh as label,(SELECT question from word_exercise where word_id=word.id LIMIT 1) as `desc` FROM word where en like '".$w."%' order by en limit 10");

                $result = $query->result_array();

                echo json_encode($result);
            }
        }
    }
}