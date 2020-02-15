<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class TimetablesController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $timetables = Timetable::with('account')->paginate(25);

        $data = $timetables->transform(function ($timetable) {
            return $this->transform($timetable);
        });

        return $this->successResponse(
            'Timetables were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $timetables->url(1),
                    'last' => $timetables->url($timetables->lastPage()),
                    'prev' => $timetables->previousPageUrl(),
                    'next' => $timetables->nextPageUrl(),
                ],
                'meta' =>
                [
                    'current_page' => $timetables->currentPage(),
                    'from' => $timetables->firstItem(),
                    'last_page' => $timetables->lastPage(),
                    'path' => $timetables->resolveCurrentPath(),
                    'per_page' => $timetables->perPage(),
                    'to' => $timetables->lastItem(),
                    'total' => $timetables->total(),
                ],
            ]
        );
    }

    /**
     * Store a new timetable in the storage.
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
            
            $timetable = Timetable::create($data);

            return $this->successResponse(
			    'Timetable was successfully added.',
			    $this->transform($timetable)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Display the specified timetable.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $timetable = Timetable::with('account')->findOrFail($id);

        return $this->successResponse(
		    'Timetable was successfully retrieved.',
		    $this->transform($timetable)
		);
    }

    /**
     * Update the specified timetable in the storage.
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
            
            $timetable = Timetable::findOrFail($id);
            $timetable->update($data);

            return $this->successResponse(
			    'Timetable was successfully updated.',
			    $this->transform($timetable)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified timetable from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $timetable = Timetable::findOrFail($id);
            $timetable->delete();

            return $this->successResponse(
			    'Timetable was successfully deleted.',
			    $this->transform($timetable)
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
            'aid' => 'required|string|min:1',
            'room' => 'required|string|min:1|max:255',
            'course' => 'required|string|min:1|max:255',
            'day' => 'required|string|min:1|max:255',
            'time' => 'required|date_format:j/n/Y g:i A', 
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
                'aid' => 'required|string|min:1',
            'room' => 'required|string|min:1|max:255',
            'course' => 'required|string|min:1|max:255',
            'day' => 'required|string|min:1|max:255',
            'time' => 'required|date_format:j/n/Y g:i A', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Transform the giving timetable to public friendly array
     *
     * @param App\Models\Timetable $timetable
     *
     * @return array
     */
    protected function transform(Timetable $timetable)
    {
        return [
            'id' => $timetable->id,
            'aid' => optional($timetable->Account)->ugId,
            'room' => $timetable->room,
            'course' => $timetable->course,
            'day' => $timetable->day,
            'time' => $timetable->time,
        ];
    }


}
