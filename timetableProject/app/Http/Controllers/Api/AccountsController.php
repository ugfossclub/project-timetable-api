<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Api\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class AccountsController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $accounts = Account::paginate(25);

        $data = $accounts->transform(function ($account) {
            return $this->transform($account);
        });

        return $this->successResponse(
            'Accounts were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $accounts->url(1),
                    'last' => $accounts->url($accounts->lastPage()),
                    'prev' => $accounts->previousPageUrl(),
                    'next' => $accounts->nextPageUrl(),
                ],
                'meta' =>
                [
                    'current_page' => $accounts->currentPage(),
                    'from' => $accounts->firstItem(),
                    'last_page' => $accounts->lastPage(),
                    'path' => $accounts->resolveCurrentPath(),
                    'per_page' => $accounts->perPage(),
                    'to' => $accounts->lastItem(),
                    'total' => $accounts->total(),
                ],
            ]
        );
    }

    /**
     * Store a new account in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->getValidator($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all());
            }

            $data = $this->getData($request);
            $data['active'] = 1;
            $account = Account::create($data);

            return $this->successResponse(
			    'Account was successfully added.',
			    $this->transform($account)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Display the specified account.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = Account::findOrFail($id);

        return $this->successResponse(
		    'Account was successfully retrieved.',
		    $this->transform($account)
		);
    }

    /**
     * Update the specified account in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        try {
            $validator = $this->getValidator($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all());
            }

            $data = $this->getData($request);
            
            $account = Account::findOrFail($id);
            $account->update($data);

            return $this->successResponse(
			    'Account was successfully updated.',
			    $this->transform($account)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified account from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $account = Account::findOrFail($id);
            $account->delete();

            return $this->successResponse(
			    'Account was successfully deleted.',
			    $this->transform($account)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }
    
    /**
     * Gets a new validator instance with the defined rules.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Support\Facades\Validator
     */
    protected function getValidator(Request $request)
    {
        $rules = [
            'ugId' => 'required|numeric|min:-2147483648|max:2147483647',
            'fName' => 'required|string|min:1|max:255',
            'lName' => 'required|string|min:1|max:255',
            'faculty' => 'required|string|min:1|max:255',
            'password' => 'required|string|min:1|max:255',
            'department' => 'required|string|min:1|max:255',
            'programme' => 'required|string|min:1|max:255', 
        ];

        return Validator::make($request->all(), $rules);
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'ugId' => 'required|numeric|min:-2147483648|max:2147483647',
            'fName' => 'required|string|min:1|max:255',
            'lName' => 'required|string|min:1|max:255',
            'faculty' => 'required|string|min:1|max:255',
            'password' => 'required|string|min:1|max:255',
            'department' => 'required|string|min:1|max:255',
            'programme' => 'required|string|min:1|max:255', 
        ];

        
        $data = $request->validate($rules);


        $data['active'] = $request->has('active');


        return $data;
    }

    /**
     * Transform the giving account to public friendly array
     *
     * @param App\Models\Account $account
     *
     * @return array
     */
    protected function transform(Account $account)
    {
        return [
            'id' => $account->id,
            'ugId' => $account->ugId,
            'fName' => $account->fName,
            'lName' => $account->lName,
            'faculty' => $account->faculty,
            'password' => $account->password,
            'department' => $account->department,
            'programme' => $account->programme,
            'active' => ($account->active) ? 'Yes' : 'No',
        ];
    }


}
