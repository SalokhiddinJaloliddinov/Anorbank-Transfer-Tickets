<?php
    session_start();

$mysqli = new mysqli('hostname', 'username', 'db_password', 'db_name') or die(mysqli_error($mysqli));

    if (isset($_POST['save'])) {
        $id = $_POST['id'];
        $servicesubcategory_id = $_POST['attr_servicesubcategory_id'];
        $service_id = $_POST['attr_service_id'];
        $ticket_ref = $_POST['transfer_to'];
        if ($ticket_ref == 'D') {
            $insert_table = 'ticket_delivery';
            $ticket_type = 'DeliveryRequest';
        } elseif ($ticket_ref == 'I') {
            $insert_table = 'ticket_incident';
            $ticket_type = 'Incident';
        } elseif ($ticket_ref == 'R') {
            $insert_table = 'ticket_request';
            $ticket_type = 'UserRequest';
        };

        if (strpos($id, 'I') !== false) {
            $from_table = 'ticket_incident';
            $from_ref = 'I';
        } elseif (strpos($id, 'R') !== false) {
            $from_table = 'ticket_request';
            $from_ref = 'R';
        } elseif (strpos($id, 'D') !== false) {
            $from_table = 'ticket_delivery';
            $from_ref = 'D';
        }

        
            $sql = "INSERT INTO " . $insert_table. "
            (id, 
            status, 
            impact, 
            priority, 
            urgency, 
            origin, 
            service_id, 
            servicesubcategory_id, 
            escalation_flag, 
            escalation_reason, 
            assignment_date,
            resolution_date,
            last_pending_date,
            cumulatedpending_timespent,
            cumulatedpending_laststart,
            tto_timespent,
            tto_laststart,
            tto_stopped,
            tto_75_deadline,
            tto_75_passed,
            tto_75_triggered,
            tto_75_overrun,
            tto_100_deadline,
            tto_100_passed,
            tto_100_triggered,
            tto_100_overrun,
            ttr_timespent,
            ttr_started,
            ttr_laststart,
            ttr_stopped,
            ttr_75_deadline,
            ttr_75_passed,
            ttr_75_triggered,
            ttr_75_overrun,
            ttr_100_deadline,
            ttr_100_passed,
            ttr_100_triggered,
            ttr_100_overrun,
            time_spent,
            resolution_code,
            solution,
            pending_reason,
            parent_problem_id,
            " . (($ticket_ref !== "D" && $from_ref !== "D") ? 'dispatch_reason, reassign_reason,' : '') . "
            public_log,
            public_log_index,
            user_satisfaction,
            user_commment
            )
            SELECT 
            r.id, 
            status, 
            impact, 
            priority, 
            urgency, 
            origin," . (($_POST['attr_service_id']) ? $service_id : 'service_id') . "," . 
            (($_POST['attr_servicesubcategory_id']) ? $servicesubcategory_id : 'servicesubcategory_id') . ", 
            escalation_flag, 
            escalation_reason, 
            assignment_date,
            resolution_date,
            last_pending_date,
            cumulatedpending_timespent,
            cumulatedpending_laststart,
            tto_timespent,
            tto_laststart,
            tto_stopped,
            tto_75_deadline,
            tto_75_passed,
            tto_75_triggered,
            tto_75_overrun,
            tto_100_deadline,
            tto_100_passed,
            tto_100_triggered,
            tto_100_overrun,
            ttr_timespent,
            ttr_started,
            ttr_laststart,
            ttr_stopped,
            ttr_75_deadline,
            ttr_75_passed,
            ttr_75_triggered,
            ttr_75_overrun,
            ttr_100_deadline,
            ttr_100_passed,
            ttr_100_triggered,
            ttr_100_overrun,
            time_spent,
            resolution_code,
            solution,
            pending_reason,
            parent_problem_id,
            " . (($ticket_ref !== "D" && $from_ref !== "D") ? 'dispatch_reason, reassign_reason,' : '') . "
            public_log,
            public_log_index,
            user_satisfaction,
            user_commment
            FROM " . $from_table . " as r JOIN ticket as t ON r.id = t.id WHERE t.ref='$id'";

            $sql_update_finalclass = "UPDATE ticket SET finalclass = '$ticket_type' WHERE ref = '$id'" ;
            $sql_update_history = "UPDATE priv_changeop as p, (SELECT id, finalclass, ref from ticket) as t
            SET p.objclass = t.finalclass WHERE p.objkey = t.id AND t.ref = '$id'";
            $sql_update_attachments = "UPDATE attachment as a, (SELECT id, finalclass, ref from ticket) as t
            SET a.item_class = t.finalclass WHERE a.item_id = t.id AND t.ref = '$id'";
            $sql_update_ref = "UPDATE ticket SET ref = replace(ref, '$from_ref', '$ticket_ref') WHERE ref = '$id'";
            $sql_delete = "DELETE FROM " . $from_table . " WHERE id IN (SELECT id from ticket WHERE ref = '$id')";

            $mysqli->query($sql) or die($mysqli->error);
            $mysqli->query($sql_delete) or die($mysqli->error);
            $mysqli->query($sql_update_finalclass) or die($mysqli->error);
            $mysqli->query($sql_update_history) or die($mysqli->error);
            $mysqli->query($sql_update_attachments) or die($mysqli->error);
            $mysqli->query($sql_update_ref) or die($mysqli->error);
            $_SESSION['message'] = "'$ticket_type' '$id' успешно перекинулся на '$from_table'";
            $_SESSION['msg_type'] = "success";

            header("location: index.php");

        /* else {
                $sql = "INSERT INTO ticket_incident
            (id, 
            status, 
            impact, 
            priority, 
            urgency, 
            origin, 
            service_id, 
            servicesubcategory_id, 
            escalation_flag, 
            escalation_reason, 
            assignment_date,
            resolution_date,
            last_pending_date,
            cumulatedpending_timespent,
            cumulatedpending_laststart,
            tto_timespent,
            tto_laststart,
            tto_stopped,
            tto_75_deadline,
            tto_75_passed,
            tto_75_triggered,
            tto_75_overrun,
            tto_100_deadline,
            tto_100_passed,
            tto_100_triggered,
            tto_100_overrun,
            ttr_timespent,
            ttr_started,
            ttr_laststart,
            ttr_stopped,
            ttr_75_deadline,
            ttr_75_passed,
            ttr_75_triggered,
            ttr_75_overrun,
            ttr_100_deadline,
            ttr_100_passed,
            ttr_100_triggered,
            ttr_100_overrun,
            time_spent,
            resolution_code,
            solution,
            pending_reason,
            parent_problem_id,
            public_log,
            public_log_index,
            user_satisfaction,
            user_commment,
            dispatch_reason,
            reassign_reason
            )
            SELECT 
            r.id, 
            status, 
            impact, 
            priority, 
            urgency, 
            origin," . 
            (($_POST['attr_service_id']) ? $service_id : 'service_id') . "," . 
            (($_POST['attr_servicesubcategory_id']) ? $servicesubcategory_id : 'servicesubcategory_id') . ", 
            escalation_flag, 
            escalation_reason, 
            assignment_date,
            resolution_date,
            last_pending_date,
            cumulatedpending_timespent,
            cumulatedpending_laststart,
            tto_timespent,
            tto_laststart,
            tto_stopped,
            tto_75_deadline,
            tto_75_passed,
            tto_75_triggered,
            tto_75_overrun,
            tto_100_deadline,
            tto_100_passed,
            tto_100_triggered,
            tto_100_overrun,
            ttr_timespent,
            ttr_started,
            ttr_laststart,
            ttr_stopped,
            ttr_75_deadline,
            ttr_75_passed,
            ttr_75_triggered,
            ttr_75_overrun,
            ttr_100_deadline,
            ttr_100_passed,
            ttr_100_triggered,
            ttr_100_overrun,
            time_spent,
            resolution_code,
            solution,
            pending_reason,
            parent_problem_id,
            public_log,
            public_log_index,
            user_satisfaction,
            user_commment,
            dispatch_reason,
            reassign_reason
            FROM ticket_request as r JOIN ticket as t ON r.id = t.id WHERE t.ref='$id'";

            $sql_update_finalclass = "UPDATE ticket SET finalclass = 'Incident' WHERE ref = '$id'" ;
            $sql_update_history = "UPDATE priv_changeop as p, (SELECT id, finalclass, ref from ticket) as t
            SET p.objclass = t.finalclass WHERE p.objkey = t.id AND t.ref = '$id'";
            $sql_update_attachments = "UPDATE attachment as a, (SELECT id, finalclass, ref from ticket) as t
            SET a.item_class = t.finalclass WHERE a.item_id = t.id AND t.ref = '$id'";
            $sql_update_ref = "UPDATE ticket SET ref = replace(ref, 'R', 'I') WHERE ref = '$id'";

            $sql_delete = "DELETE FROM ticket_request WHERE id IN (SELECT id from ticket WHERE ref = '$id')";

            $mysqli->query($sql) or die($mysqli->error);
            $mysqli->query($sql_delete) or die($mysqli->error);
            $mysqli->query($sql_update_finalclass) or die($mysqli->error);
            $mysqli->query($sql_update_history) or die($mysqli->error);
            $mysqli->query($sql_update_attachments) or die($mysqli->error);
            $mysqli->query($sql_update_ref) or die($mysqli->error);
            $_SESSION['message'] = "UserRequest '$id' успешно перекинулся на Incident";
            $_SESSION['msg_type'] = "success";

            header("location: index.php");
        } */
    }
?>