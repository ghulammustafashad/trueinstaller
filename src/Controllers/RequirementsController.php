<?php

namespace ghulammustafashad\trueinstaller\Controllers;

use Illuminate\Routing\Controller;
use ghulammustafashad\trueinstaller\Helpers\RequirementsChecker;

class RequirementsController extends Controller
{
    /**
     * @var RequirementsChecker
     */
    protected $requirements;

    /**
     * @param RequirementsChecker $checker
     */
    public function __construct(RequirementsChecker $checker)
    {
        $this->requirements = $checker;
    }

    /**
     * Display the requirements page.
     *
     * @return \Illuminate\View\View
     */
    public function requirements()
    {
        $phpSupportInfo = $this->requirements->checkPHPversion(
            config('trueinstaller.core.minPhpVersion')
        );
        $requirements = $this->requirements->check(
            config('trueinstaller.requirements')
        );

        return view('trueinstaller.requirements', compact('requirements', 'phpSupportInfo'));
    }
}
