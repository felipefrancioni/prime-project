<?php

    namespace SdcProject\Events;

    use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
    use Illuminate\Queue\SerializesModels;
    use LucaDegasperi\OAuth2Server\Facades\Authorizer;
    use SdcProject\Entities\ProjectTask;

    class TaskWasIncluded extends Event implements ShouldBroadcast {


        use SerializesModels;

        /**
         * @var ProjectTask
         */
        public $task;

        public function __construct(ProjectTask $task) {
            $this->task = $task;
        }

        /**
         * Get the channels the event should broadcast on.
         *
         * @return array
         */
        public function broadcastOn() {
            return ['user.' . Authorizer::getResourceOwnerId()];
        }
    }