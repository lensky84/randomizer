<?php

/**
 * Class Randomizer uses for get random opponent for each participant
 * and send email message for participant with information about his opponent
 */
class Randomizer
{
    /**
     * @var array
     */
    private $participants = [];

    /**
     * Constructor
     *
     * @param array $participants
     */
    public function __construct(array $participants)
    {
        if (empty($participants)) {
            throw new \InvalidArgumentException("Array of participants cannot be empty");
        }
        $this->participants = $participants;
    }

    /**
     * Run randomizer for get opponents for participants
     *
     * @throws \Exception
     */
    public function run()
    {
        foreach ($this->participants as $participant) {
            $opponent = $this->getOpponent($participant);
            $this->sendEmail($participant, $opponent);
        }
    }

    /**
     * Get opponent for participant
     *
     * @param string $participant
     *
     * @return string
     */
    protected function getOpponent($participant)
    {
        $opponentKey = array_rand($this->participants);
        $opponent = $this->participants[$opponentKey];
        if ($opponent == $participant) {
            return $this->getOpponent($participant);
        }
        unset($this->participants[$opponentKey]);

        return $opponent;
    }

    /**
     * Send email message to participant with information about his opponent
     *
     * @param string $participant
     * @param string $opponent
     *
     * @throws \Exception
     */
    protected function sendEmail($participant, $opponent)
    {
        list($participantName, $participantEmail) = explode(';', $participant);
        list($opponentName, $opponentEmail) = explode(';', $opponent);
        $subject = 'Your opponent';
        $message = 'Hello, ' . $participantName . '!' . PHP_EOL;
        $message .= 'Your opponent: ' . $opponentName . PHP_EOL;
        $message .= 'His email address for contact: ' . $opponentEmail . PHP_EOL;

        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com';

        if (!mail($participantEmail, $subject, $message, $headers)) {
            throw new \Exception("Can't send email on address " . $participantEmail);
        }
    }
}


