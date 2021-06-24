<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTestAnswerRequest;
use App\Http\Requests\StoreTestAnswerRequest;
use App\Http\Requests\UpdateTestAnswerRequest;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\TestAnswer;
use App\Models\TestResult;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TestAnswersController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('test_answer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TestAnswer::with(['test_result', 'question', 'option', 'created_by'])->select(sprintf('%s.*', (new TestAnswer())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'test_answer_show';
                $editGate = 'test_answer_edit';
                $deleteGate = 'test_answer_delete';
                $crudRoutePart = 'test-answers';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('test_result_score', function ($row) {
                return $row->test_result ? $row->test_result->score : '';
            });

            $table->addColumn('question_question_text', function ($row) {
                return $row->question ? $row->question->question_text : '';
            });

            $table->addColumn('option_option_text', function ($row) {
                return $row->option ? $row->option->option_text : '';
            });

            $table->editColumn('is_correct', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_correct ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'test_result', 'question', 'option', 'is_correct']);

            return $table->make(true);
        }

        return view('admin.testAnswers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('test_answer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test_results = TestResult::all()->pluck('score', 'id')->prepend(trans('global.pleaseSelect'), '');

        $questions = Question::all()->pluck('question_text', 'id')->prepend(trans('global.pleaseSelect'), '');

        $options = QuestionOption::all()->pluck('option_text', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.testAnswers.create', compact('test_results', 'questions', 'options'));
    }

    public function store(StoreTestAnswerRequest $request)
    {
        $testAnswer = TestAnswer::create($request->all());

        return redirect()->route('admin.test-answers.index');
    }

    public function edit(TestAnswer $testAnswer)
    {
        abort_if(Gate::denies('test_answer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test_results = TestResult::all()->pluck('score', 'id')->prepend(trans('global.pleaseSelect'), '');

        $questions = Question::all()->pluck('question_text', 'id')->prepend(trans('global.pleaseSelect'), '');

        $options = QuestionOption::all()->pluck('option_text', 'id')->prepend(trans('global.pleaseSelect'), '');

        $testAnswer->load('test_result', 'question', 'option', 'created_by');

        return view('admin.testAnswers.edit', compact('test_results', 'questions', 'options', 'testAnswer'));
    }

    public function update(UpdateTestAnswerRequest $request, TestAnswer $testAnswer)
    {
        $testAnswer->update($request->all());

        return redirect()->route('admin.test-answers.index');
    }

    public function show(TestAnswer $testAnswer)
    {
        abort_if(Gate::denies('test_answer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $testAnswer->load('test_result', 'question', 'option', 'created_by');

        return view('admin.testAnswers.show', compact('testAnswer'));
    }

    public function destroy(TestAnswer $testAnswer)
    {
        abort_if(Gate::denies('test_answer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $testAnswer->delete();

        return back();
    }

    public function massDestroy(MassDestroyTestAnswerRequest $request)
    {
        TestAnswer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
