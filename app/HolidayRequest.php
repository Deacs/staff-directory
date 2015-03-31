<?php  namespace App;

/**
 * This class represents an individual holiday request
 * It is important to note that a request of 5 successive days will be stored as 5 individual requests
 * This allows individual days of a block request to be approved or declined independently
 * without the user having to re-submit the entire request
 */

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon as Carbon;

class HolidayRequest extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'holiday_requests';

    protected $fillable = [
        'user_id',
        'date',
        'status_id',
        'approved_by',
        'declined_by'
    ];

    public $date;

    /**
     * Specify the date for the request
     *
     * @param $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function approver()
    {
        return $this->hasOne('App\User', 'id', 'approved_by');
    }

    public function decliner()
    {
        return $this->hasOne('App\User', 'id', 'declined_by');
    }

    public function status()
    {
        return $this->hasOne('App\Status');
    }

    /**
     * Is this request pending
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status_id == 1;
    }

    /**
     * Has this request been approved
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->status_id == 2;
    }

    /**
     * Has this request been declined
     *
     * @return bool
     */
    public function isDeclined()
    {
        return $this->status_id == 3;
    }

    /**
     * Is this request currently active - i.e. the user is taking this holiday
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status_id == 4;
    }

    /**
     * Has this request been cancelled
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status_id == 5;
    }

    /**
     * Has this request completed i.e. an approved holiday request is in teh past and has been taken
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status_id == 6;
    }

    /**
     * Attempt to record the request
     *
     * @throws \Exception
     * @return bool
     */
    public function place()
    {
        if ($this->validate()) {
            return true;
        }
    }

    /**
     * Validate the requested date
     *
     * @throws \Exception
     * @return bool
     */
    private function validate()
    {
        $dt = new Carbon();

        switch (true) {
            // The requested date cannot be in the past
            case Carbon::now()->gte($this->date):
                throw new \Exception('You cannot make a Holiday Request for a date in the past');
                break;
            // The requested date must be within the current year
            case $dt->year != $this->date->year:
                throw new \Exception('Holiday Requests can only be made for the current year');
                break;
            default:
                return true;
        }
    }

    /**
     * Approve a holiday request
     *
     * @return bool
     */
    public function approve()
    {
        if ($this->canBeApproved()) {
            $this->status_id = 2;
            // save();
            $this->sendApprovalNotification();

            return true;
        }

        return false;
    }

    /**
     * Cancel an existing Holiday Request
     *
     * @return bool
     */
    public function cancel()
    {
        if ($this->canBeCancelled()) {
            $this->status_id = 5;
            // save();
            $this->sendCancellationNotification();

            return true;
        }

        return false;
    }

    /**
     * Decline a holiday request
     *
     * @return bool
     */
    public function decline()
    {
        if ($this->canBeDeclined()) {
            $this->status_id = 3;
            //save();
            $this->sendDeclineNotification();

            return true;
        }

        return false;
    }

    /**
     * Can this request be approved
     *
     * @throws \Exception
     * @return bool
     */
    private function canBeApproved()
    {
        // There are only certain states that allow approval
        if ($this->isPending()) {
            return true;
        }

        // If the request is not in an allowable state, throw the appropriate exception
        $this->explainApprovalRefusal();
    }

    /**
     * Can this request be cancelled
     *
     * @throws \Exception
     * @return bool
     */
    private function canBeCancelled()
    {
        // There are only certain states that allow cancellation
        if ($this->isPending() || $this->isApproved()) {
            return true;
        }

        // If the request is not in an allowable state, throw the appropriate exception
        $this->explainCancellationRefusal();
    }

    /**
     * Can this request be declined
     *
     * @throws \Exception
     * @return bool
     */
    private function canBeDeclined()
    {
        // There are only certain states that allow a request to be declined
        if ($this->isPending() || $this->isApproved()) {
            return true;
        }

        // If the request is not in an allowable state, throw the appropriate exception
        $this->explainDeclineRefusal();
    }

    /**
     * Explain why changing to approved status was refused
     *
     * @throws \Exception
     * @return bool
     */
    private function explainApprovalRefusal()
    {
        switch (true) {
            case $this->isApproved():
                throw new \Exception('Holiday Request has already been approved');
                break;
            case $this->isDeclined():
                throw new \Exception('Holiday Request cannot be approved, it has already been declined');
                break;
            case $this->isActive():
                throw new \Exception('Holiday Request cannot be approved, it is currently active');
                break;
            case $this->isCancelled():
                throw new \Exception('Holiday Request cannot be approved, it has been cancelled');
                break;
            case $this->isCompleted():
                throw new \Exception('Holiday Request cannot be approved, it has already been completed');
                break;
            default:
                return true;
        }
    }

    /**
     * Explain why moving to cancelled status was refused
     *
     * @throws \Exception
     * @return bool
     */
    private function explainCancellationRefusal()
    {
        switch (true) {
            case $this->isDeclined():
                throw new \Exception('Holiday Request cannot be cancelled, it has already been declined');
                break;
            case $this->isActive():
                throw new \Exception('Holiday Request cannot be cancelled, it is currently active');
                break;
            case $this->isCancelled():
                throw new \Exception('Holiday Request has already been cancelled');
                break;
            case $this->isCompleted():
                throw new \Exception('Holiday Request cannot be cancelled, it has already been completed');
                break;
            default:
                return true;
        }
    }

    /**
     * Explain why moving to declined status was refused
     *
     * @throws \Exception
     * @return bool
     */
    private function explainDeclineRefusal()
    {
        switch (true) {
            case $this->isDeclined():
                throw new \Exception('Holiday Request has already been declined');
                break;
            case $this->isActive():
                throw new \Exception('Holiday Request cannot be declined, it is currently active');
                break;
            case $this->isCancelled():
                throw new \Exception('Holiday Request cannot be declined, it has already been cancelled');
                break;
            case $this->isCompleted():
                throw new \Exception('Holiday Request cannot be declined, it has already been completed');
                break;
            default:
                return true;
        }
    }

    /**
     * Send an approved notification
     *
     * @return bool
     */
    public function sendApprovalNotification()
    {
        return true;
    }

    /**
     * Send an declined notification
     *
     * @return bool
     */
    public function sendDeclineNotification()
    {
        return true;
    }

    /**
     * Send a successful cancellation notification
     *
     * @return bool
     */
    public function sendCancellationNotification()
    {
        return true;
    }

}