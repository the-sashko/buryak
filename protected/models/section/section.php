<?php
class Section extends ModelCore
{
    public function getAll(int $page = 1, bool $viewHidden = FALSE) : array
    {
        $sections = $this->object->getAllSection($page, $viewHidden);

        if (count($sections) < 1) {
            return NULL;
        }

        return $this->getVOArray($sections);
    }

    public function getCountAll(bool $viewHidden = FALSE) : int
    {
        return $this->object->getCountAllSection($viewHidden);
	}

    public function getByID(
		int  $sectionID  = 0,
		bool $viewHidden = FALSE
	) : SectionVO
    {
        $sectionData = $this->object->getSectionByID($sectionID, $viewHidden);

        if (count($sectionData) < 1) {
            return NULL;
        }

        return $this->getVO($sectionData);
	}

    public function getBySlug(
		string $sectionSlug = '',
		bool   $viewHidden  = FALSE
	) : SectionVO
    {
        $sectionData = $this->object->getSectionBySlug(
			$sectionSlug,
			$viewHidden
		);

        if (count($sectionData) < 1) {
            return NULL;
        }

        return $this->getVO($sectionData);
	}

    public function create($formData) : array
    {
        if (!$this->_validateFormDataFormat($formData)) {
            return [FALSE, 'Form Data Has Invalid Format'];
        }

        list(
			$slug,
			$title,
			$desription,
			$ageRestriction,
			$status,
			$sort
        ) = $this->_getFormParams($formData);

        list($status, $errors) = $this->_validateFormData(
			$slug,
			$title,
			$desription,
			$status
		);

		$sort = $sort > 0 ? $sort : 0;

		$ageRestriction = $ageRestriction > 0 ? $ageRestriction : 0;

		if (!$status) {
            return [FALSE, $errors];
		}
		
		$status = $this->object->addSection(
			$slug,
			$title,
			$desription,
			$ageRestriction,
			$status,
			$sort
		);
		
		if (!$status) {
			return [FALSE, 'Internal DB Error!'];
		}

		return [TRUE, NULL];
    }

    public function remove(int $sectionID = 0) : bool
    {
        return $this->object->removeSectionByID($sectionID);
	}

    public function formatText(string $text = '') : string
    {
        /*$text = $this->parseLinkShortCode($post['text']);
        $text = $this->parseYoutubeShortCode($post['text']);
        $text = $this->normalizeText($post['text']);
        $text = $this->parseReplyShortCode($post['text'], $post['section_id']);
        $text = $this->markup2HTML($post['text']);*/
        // To-Do
        return $text;
	}

    private function _validateFormDataFormat(array $formData = []) : bool
    {
        return isset($formData['slug']) &&
               isset($formData['title']) &&
               isset($formData['desription']) &&
               isset($formData['age_restriction']) &&
               isset($formData['status']) &&
               isset($formData['sort']);
	}

    private function _validateFormData(
		string $slug       = '',
		string $title      = '',
		string $desription = '',
		string $status     = ''
    ) : array
    {        
        list($status, $errors) = $this->_validateSlug($slug);
        list($status, $errors) = $this->_validateTitle($title);
        list($status, $errors) = $this->_validateDescription($desription);
        list($status, $errors) = $this->_validateStatus($status);

        return [$status, $errors];
    }

    private function _validateSlug(string $slug = '') : array
    {
		// To-Do

        return [FALSE, []];
	}

    private function _validateTitle(string $title = '') : array
    {
		// To-Do

        return [FALSE, []];
    }

    private function _validateDescription(string $desription = '') : array
    {
		// To-Do

        return [FALSE, []];
	}

    private function _validateStatus(string $status = '') : array
    {
		// To-Do

        return [FALSE, []];
	}

    private function _getFormParams(array $formData = []) : array
    {
        return [
            (string) $formData['slug'],
            (string) $formData['title'],
            (string) $formData['desription'],
            (int)    $formData['age_restriction'],
            (string) $formData['status'],
            (int)    $formData['sort']
		];
    }
}
?>
