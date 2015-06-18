<?php  namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class HolidayHistory
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $data = $view->getData();
        $member = $data['member'];

        $view->with('history', $member->holidayRequests);
    }
}