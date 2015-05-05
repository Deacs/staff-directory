<?php

// https://laracasts.com/lessons/whats-new-in-testdummy

use App\HolidayRequest;
use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;
use \Carbon\Carbon as Carbon;
use App\Repositories\HolidayRepository;
use App\Status as Status;

class HolidayRequestTest extends DbTestCase {

    protected $repository;

    public function setUp()
    {
        parent::setUp();

        $this->repository = new HolidayRepository;
    }

    // -- Check correct status id has been set after transitions
    function test_the_appropriate_status_is_set_after_being_set_to_approved()
    {
        $department         = Factory::create('App\Department', ['id' => 1]);
        $requesting_user    = Factory::create('App\User', ['department_id' => $department->id]);
        $approving_user     = Factory::create('App\User', ['department_id' => $department->id]);
        $holiday_request    = Factory::create('App\HolidayRequest');

        $holiday_request->setRequestDate($this->makeValidDate());
        $holiday_request->requestingUser($requesting_user);
        $approving_user->lead = 1;
        $holiday_request->approvingUser($approving_user);
        $holiday_request->approve();

        $this->assertEquals(Status::APPROVED_ID, $holiday_request->status_id);
    }

    function test_the_appropriate_status_is_set_after_being_set_to_declined()
    {
        $department         = Factory::create('App\Department', ['id' => 1]);
        $requesting_user    = Factory::create('App\User', ['department_id' => $department->id]);
        $approving_user     = Factory::create('App\User', ['department_id' => $department->id]);
        $holiday_request    = Factory::create('App\HolidayRequest');

        $holiday_request->setRequestDate($this->makeValidDate());
        $holiday_request->requestingUser($requesting_user);
        $approving_user->lead = 1;
        $holiday_request->approvingUser($approving_user);
        $holiday_request->decline();

        $this->assertEquals(Status::DECLINED_ID, $holiday_request->status_id);
    }

    function test_the_appropriate_status_is_set_after_being_set_to_cancelled()
    {
        $requesting_user    = Factory::create('App\User');
        $holiday_request    = Factory::create('App\HolidayRequest', ['user_id' => $requesting_user->id]);

        $holiday_request->requestingUser($requesting_user);
        $holiday_request->cancel();

        $this->assertEquals(Status::CANCELLED_ID, $holiday_request->status_id);
    }

    // -- Test that failed validations throw the correct exceptions
    function test_request_for_a_past_date_throws_exception()
    {
        $holiday_request = new HolidayRequest();
        // Set the test day as a Monday to ensure the weekend validation passes
        $holiday_request->setRequestDate((new Carbon('this monday'))->subWeeks(2));

        try {
            $holiday_request->place();
            return false;
        } catch (Exception $e) {
            $this->assertEquals('You cannot make a Holiday Request for a date in the past', $e->getMessage());
        }

        $this->assertCount(0, $this->repository->getAllRequests());
    }

    function test_request_outside_of_the_current_year_throws_exception()
    {
        $holiday_request = new HolidayRequest();
        $holiday_request->setRequestDate((new Carbon())->addYear());

        try {
            $holiday_request->place();
            return false;
        } catch (Exception $e) {
            $this->assertEquals('Holiday Requests can only be made for the current year', $e->getMessage());
        }

        $this->assertCount(0, $this->repository->getAllRequests());
    }

    function test_request_for_a_weekend_will_throw_an_exception()
    {
        $holiday_request = new HolidayRequest();
        // Set the test date to next Saturday to ensure the future date validation passes
        $holiday_request->setRequestDate(new Carbon('next saturday'));

        try {
            $holiday_request->place();
            return false;
        } catch (Exception $e) {
            $this->assertEquals('Requested date is a weekend', $e->getMessage());
        }

        $this->assertCount(0, $this->repository->getAllRequests());
    }

    // -- Test User permissions and actions errors are handled correctly

    function test_user_attempting_to_approve_own_request_will_throw_exception()
    {
        $user               = Factory::create('App\User');
        $user->lead         = 1;
        $holiday_request    = new HolidayRequest();

        $holiday_request->setRequestDate($this->makeValidDate());
        $holiday_request->requestingUser($user);
        $holiday_request->approvingUser($user);

        try {
            $holiday_request->approve();
            return false;
        } catch (Exception $e) {
            $this->assertEquals('You cannot approve your own Holiday Requests', $e->getMessage());
        }

        $this->assertCount(0, $this->repository->getAllRequests());
    }

    function test_non_department_leads_attempting_to_approve_request_will_throw_exception()
    {
        $user               = Factory::create('App\User');
        $user->lead         = 0;
        $holiday_request    = new HolidayRequest();

        $holiday_request->setRequestDate($this->makeValidDate());
        $holiday_request->requestingUser($user);
        $holiday_request->approvingUser($user);

        try {
            $holiday_request->approve();
            return false;
        } catch (Exception $e) {
            $this->assertEquals('Only Department Leads can approve Holiday Requests', $e->getMessage());
        }

        $this->assertCount(0, $this->repository->getAllRequests());
    }

    function test_department_lead_attempting_approval_of_request_for_members_of_another_team_will_throw_exception()
    {
        $holiday_request = new HolidayRequest();
        $requesting_user = Factory::create('App\User', ['department_id' => 1]);
        $approving_user = Factory::create('App\User', ['department_id' => 2]);
        $approving_user->lead = 1;

        $holiday_request->setRequestDate($this->makeValidDate());
        $holiday_request->requestingUser($requesting_user);
        $holiday_request->approvingUser($approving_user);

        try {
            $holiday_request->approve();
            return false;
        } catch (Exception $e) {
            $this->assertEquals('You may only approve Holiday Requests from members of your own Department', $e->getMessage());
        }

        $this->assertCount(0, $this->repository->getAllRequests());
    }

    // TODO
    // Requests cannot be declined by users other than dept lead or super user
    function test_non_department_lead_or_super_user_attempting_decline_of_request_will_throw_exception()
    {
        $holiday_request = Factory::create('App\HolidayRequest', ['status_id' => Status::PENDING_ID]);



    }

    // Requests can only be cancelled by requesting user

    // -- Test allowable actions

    // Dept leads can approve their own team's request

    // Super Users can approve requests from members of any team

    // Requests will be correctly stored

    // A user can cancel their own requests

    // -- Test correct notifications are triggered

//    function it_will_allow_department_lead_to_approve_holiday_for_own_department_members()
//    {
//        $requesting_user    = new User();
//        $approving_user     = new User();
//
//        $requesting_user->id            = 1;
//        $requesting_user->department_id = 1;
//        $approving_user->id             = 2;
//        $approving_user->department_id  = 1;
//        $approving_user->lead           = 1;
//
//        // Ensure the date validation passes
//        $this->makeValidDate();
//
//        $this->requestingUser($requesting_user);
//        $this->approvingUser($approving_user);
//
//        $this->approve()->shouldReturn(true);
//    }

    // ------------------

    // -- Test collection returns by parameter

    public function test_get_requests_by_user_id()
    {
        $user = Factory::create('App\User');
        // Holiday Requests for the newly created User
        Factory::times(2)->create('App\HolidayRequest', ['user_id' => $user->id]);
        // Scaffold some extra Requests that are not linked to the newly created User
        Factory::times(3)->create('App\HolidayRequest');

        $requests = $this->repository->getRequestsByUserId($user->id);
        // Sanity check - did all scaffolded records make it to the DB
        $this->assertCount(5, $this->repository->getAllRequests());
        $this->assertCount(2, $requests);
    }

    public function test_get_requests_by_status_id()
    {
        $status = Factory::create('App\Status');
        Factory::times(4)->create('App\HolidayRequest', ['status_id' => $status->id]);
        Factory::times(6)->create('App\HolidayRequest');

        $requests = $this->repository->getRequestsByStatusId($status->id);
        // Sanity check - did all scaffolded records make it to the DB
        $this->assertCount(10, $this->repository->getAllRequests());
        $this->assertCount(4, $requests);
    }

    public function test_get_requests_approved_by_user_id()
    {
        $user = Factory::create('App\User', ['lead' => 1]);
        $status = Factory::create('App\Status', ['id' => \App\Status::APPROVED_ID]);
        Factory::times(4)->create('App\HolidayRequest', ['approved_by' => $user->id, 'status_id' => $status->id]);
        Factory::times(5)->create('App\HolidayRequest');

        $requests = $this->repository->getRequestsApprovedByUserId($user->id);
        // Sanity check - did all scaffolded records make it to the DB
        $this->assertCount(9, $this->repository->getAllRequests());
        $this->assertCount(4, $requests);
    }

    public function test_get_requests_by_department_id()
    {
        $department = Factory::create('App\Department', ['id' => 1]);
        $user_1 = Factory::create('App\User', ['department_id' => $department->id]);
        $user_2 = Factory::create('App\User', ['department_id' => $department->id]);
        Factory::times(3)->create('App\HolidayRequest', ['user_id' => $user_1->id]);
        Factory::times(1)->create('App\HolidayRequest', ['user_id' => $user_2->id]);
        Factory::times(3)->create('App\HolidayRequest');

        $requests = $this->repository->getRequestsByDepartmentId($department->id);
        // Sanity check - did all scaffolded records make it to the DB
        $this->assertCount(7, $this->repository->getAllRequests());
        $this->assertCount(4, $requests);
    }

    public function test_get_requests_for_specified_year()
    {
        $dt_1 = (new Carbon)->today();
        $dt_2 = (new Carbon)->subYear();

        Factory::times(3)->create('App\HolidayRequest', ['request_date' => $dt_1]);
        Factory::times(2)->create('App\HolidayRequest', ['request_date' => $dt_2]);

        $requests = $this->repository->getRequestsInSpecifiedYear($dt_1->year);
        // Sanity check - did all scaffolded records make it to the DB
        $this->assertCount(5, $this->repository->getAllRequests());
        $this->assertCount(3, $requests);
    }

    // -- Utility Functions

    /**
     * Ensure the date set is valid
     * Date validation checks for a date in the future, that is not a weekend and is this year
     *
     * @return $this
     */
    private function makeValidDate()
    {
        // Ensure the weekend validation passes
        $dt = new Carbon('next friday');
        // Prevent validation failures when next Friday is actually the following year
        $dt->year((new Carbon())->year);

        return $dt;
    }

}
