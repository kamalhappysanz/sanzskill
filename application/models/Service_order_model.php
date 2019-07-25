<?php

Class service_order_model extends CI_Model
{

  public function __construct()
  {
      parent::__construct();
      $this->load->model('smsmodel');


  }



  function get_pending_orders(){
    $check="SELECT lu.phone_no,COUNT(soa.service_order_id) AS number_of_orders,st.from_time,st.to_time,s.service_name,so.*
    FROM service_orders AS so LEFT JOIN service_order_additional AS soa ON so.id = soa.service_order_id LEFT JOIN login_users AS  lu ON lu.id=so.customer_id
    LEFT JOIN service_timeslot AS st ON st.id=so.order_timeslot LEFT JOIN services AS s ON s.id=so.service_id WHERE so.status='Pending' GROUP BY so.id ORDER BY so.created_at DESC";
    $result=$this->db->query($check);
    return $result->result();

    }

    function get_ongoing_orders(){
       $check="SELECT lu.phone_no,COUNT(soa.service_order_id) AS number_of_orders,st.from_time,st.to_time,s.service_name,so.*
      FROM service_orders AS so LEFT JOIN service_order_additional AS soa ON so.id = soa.service_order_id LEFT JOIN login_users AS  lu ON lu.id=so.customer_id
      LEFT JOIN service_timeslot AS st ON st.id=so.order_timeslot LEFT JOIN services AS s ON s.id=so.service_id WHERE so.status!='Pending' AND so.status!='Cancelled' AND so.status!='Completed' AND so.status!='Rejected' GROUP BY so.id ORDER BY so.created_at DESC";
      $result=$this->db->query($check);
      return $result->result();

      }

  function get_order_details($service_order_id){
    $id=base64_decode($service_order_id)/98765;
    $check="SELECT lu.phone_no,COUNT(soa.service_order_id) AS number_of_orders,st.from_time,st.to_time,s.service_name,so.*
    FROM service_orders AS so LEFT JOIN service_order_additional AS soa ON so.id = soa.service_order_id LEFT JOIN login_users AS  lu ON lu.id=so.customer_id
    LEFT JOIN service_timeslot AS st ON st.id=so.order_timeslot LEFT JOIN services AS s ON s.id=so.service_id WHERE  so.id='$id'";
    $result=$this->db->query($check);
    return $result->result();
  }


  function get_service_additional($service_order_id){
      $id=base64_decode($service_order_id)/98765;
      $query="SELECT soa.*,s.service_name FROM service_order_additional AS soa
      LEFT JOIN services AS s ON s.id=soa.service_id WHERE soa.status='Pending' AND service_order_id='$id'";
      $result=$this->db->query($query);
      return $result->result();
  }




  function get_service_provider($service_order_id){
    $id=base64_decode($service_order_id)/98765;
    $query="SELECT spd.owner_full_name,soh.* FROM service_order_history AS soh left join service_provider_details as spd on spd.user_master_id=soh.serv_prov_id
    WHERE  service_order_id='$id' order by created_at desc";
    $result=$this->db->query($query);
    return $result->result();
  }

  function get_service_payments($service_order_id){
    $id=base64_decode($service_order_id)/98765;
    $query="SELECT  * FROM  service_payments WHERE service_order_id='$id'";
    $result=$this->db->query($query);
    return $result->result();
  }

  function get_payment_history($service_order_id){
    $id=base64_decode($service_order_id)/98765;
    $query="SELECT * FROM service_payment_history WHERE service_order_id='$id'";
    $result=$this->db->query($query);
    return $result->result();
  }

    function get_provider_list($service_order_id){
      $id=base64_decode($service_order_id)/98765;
      $query="SELECT lu.id AS user_id,spd.owner_full_name,vs.* FROM vendor_status AS vs
      LEFT JOIN service_provider_details AS spd ON spd.user_master_id=vs.serv_pro_id AND spd.serv_prov_display_status='Active'
      LEFT JOIN login_users AS lu ON lu.id=vs.serv_pro_id WHERE NOT EXISTS( SELECT * FROM service_order_history AS soh WHERE soh.service_order_id='$id' AND soh.serv_prov_id = vs.serv_pro_id)";
      $result=$this->db->query($query);
      return $result->result();
    }


    function assign_orders($prov_id,$id){
      $service_order_id=base64_decode($id)/98765;
      $select="SELECT * FROM login_users AS lu WHERE id='$prov_id'";
      $result=$this->db->query($select);
      $res=$result->result();
      foreach($res as $rows){}
        $phone_no=$rows->phone_no;
        $notes="You Received order from Customer.Please look into app for more details";
        $this->smsmodel->send_sms($phone_no,$notes);
        $update="UPDATE service_order_history SET status='Expired' WHERE service_order_id='$service_order_id'";
        $res_update=$this->db->query($update);
        $insert="INSERT INTO service_order_history (service_order_id,serv_prov_id,status,created_at) VALUES('$service_order_id','$prov_id','Requested',NOW())";
        $res_inset=$this->db->query($insert);
        if($res_inset){
            $data = array("status" => "success");
              return $data;
        }else{
          $data = array("status" => "failed");
            return $data;
        }
    }









}
?>