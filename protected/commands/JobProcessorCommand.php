<?php
class JobProcessorCommand extends CConsoleCommand{
    /*public function run($args) {
        Yii::log('just a test warning from ' . __FILE__ . ':' . __LINE__, CLogger::LEVEL_INFO);
        echo "this is TestCommand. \n";
        echo '$args array is ' . (empty($args) ? "empty" : print_r($args, true)) . "\n";
    }*/

    private function getJobs() {
//        return JobScheduled::model()->findAll();
        return JobScheduled::model()->active()->current()->findAll();
    }

    public function run($args) {
        echo get_class(Yii::app()) . "\n";
        $jobs = $this->getJobs();
        /** @var JobScheduled $job */
        foreach ($jobs as $job) {
            echo 'Running schedule item #' . $job->id . ': "' . $job->job->name . '" scheduled for ' . $job->scheduled_time . "\n";
            $logMsg = "Running - Job [" . $job->job->name . "] Action [" . $job->job->action . "] Parameters [" . $job->params . "] scheduled for " . $job->scheduled_time;
            Yii::log($logMsg, CLogger::LEVEL_INFO, 'jobprocessor');
            $name = $job->job->action;
            $job->started = new CDbExpression('NOW()');
            if (!$job->save()) {
                throw new CDbException('cannot save at ' . __FILE__ . ':' . __LINE__);
            }
            $job->output = json_encode($this->$name($job->params, $logMsg));
            $job->completed = new CDbExpression('NOW()');
            if (!$job->save()) {
                throw new CDbException('cannot save at ' . __FILE__ . ':' . __LINE__);
            }
        }
    }

    private function SendWishlist($params = '', $logMsg = '') {
        if ($this->sendEmail('noleafclover2007@gmail.com', '<nebazori@gmail.com>', mb_substr($logMsg, 0, 40, 'utf8'), $logMsg)) {
            return 'done';
        }
    }

    private function RunReport($params = '', $logMsg = '') {
        sleep(2);
        return;
    }

    private function SendCert($params = '', $logMsg = '') {
        sleep(2);
        return;
    }

    /**
     * @param $to
     * @param $from
     * @param $subject
     * @param $message
     * @return bool
     * @throws CException
     */
    private function mailsend($to, $from, $subject, $message) {
        $mail = Yii::app()->Smtpmail;
        $mail->SetFrom($from, $from);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to, "");
        if (!$mail->Send()) {
            throw new CException("Mailer Error: " . $mail->ErrorInfo);
        }
        return true;
    }

    private function sendEmail($to, $from, $subject, $message) {
//        $headers = $this->getHeaders();
        $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
//        if (($from = $this->getSentFrom()) !== null) {
        $matches = array();
        preg_match_all('/([^<]*)<([^>]*)>/iu', $from, $matches);
//            if (isset($matches[1][0], $matches[2][0])) {
//                $name = $this->utf8 ? '=?UTF-8?B?' . base64_encode(trim($matches[1][0])) . '?=' : trim($matches[1][0]);
        $from = trim($matches[2][0]);
//                $headers[] = "From: {$name} <{$from}>";
//            } else
//                $headers[] = "From: {$from}";
//            $headers[] = "Reply-To: {$from}";
//        }
//        if ($this->mailer == 'smtp')
        $this->mailsend($to, $from, $subject, $message); // send thru smtp
//        else
//            mail($to, $subject, $message, implode("\r\n", $headers));
        return true;
    }
}
