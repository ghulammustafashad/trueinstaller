<?php

namespace ghulammustafashad\trueinstaller\Controllers;

use Illuminate\Routing\Controller;
use ghulammustafashad\trueinstaller\Events\TrueInstallerFinished;
use ghulammustafashad\trueinstaller\Helpers\EnvironmentManager;
use ghulammustafashad\trueinstaller\Helpers\FinalInstallManager;
use ghulammustafashad\trueinstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \ghulammustafashad\trueinstaller\Helpers\InstalledFileManager $fileManager
     * @param \ghulammustafashad\trueinstaller\Helpers\FinalInstallManager $finalInstall
     * @param \ghulammustafashad\trueinstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('trueinstaller.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
